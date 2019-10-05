<?php

namespace App\Console\Commands;

use App\Filter;
use App\Page;
use App\Site;
use Illuminate\Console\Command;
use DateInterval;
use DateTime;

class ParseYoutube extends Command
{
    private  $apiYoutube = 'AIzaSyDhlMpjff2RKLYEcCkpM_gSiBlt2hphcn8';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:youtube {url} {--stop=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $channel         = $this->argument('url');

      $id              =  Site::updateOrCreate([ 'url' =>$channel])->id;
      $queueName       = $this->option('stop');
      $filterChannel   = $this->get_youtube_channel_ID($channel);
      $videoChannel    = $this->getVideoChannel($filterChannel);

        foreach ($videoChannel as $videoId){
           $this->getVideo($videoId, $id, $queueName);
        }

    }


    public function getVideo($video_id, $site_id, $queueName = [])
    {
        $arraymin   = array("минута", "минуты", "минут");
        $arraysec   = array("'секунда", "секунды", "секунд");
        $arraygolos = array("голос", "голоса", "голосов");

        $yprev = false; // настройка превью: если false (default) - 120px x 90px; если true (medium) - 320px x 180px
        $ykey  = $this->apiYoutube;
        $yurl  = $video_id;
        $api   = $this->get_ydata("https://www.googleapis.com/youtube/v3/videos?id=".$yurl."&part=snippet%2Cstatistics%2CcontentDetails&key=".$ykey); // спарсили файл с информацией о видео
        $youtube = json_decode($api); // преобразовали JSON-строку в объект PHP
        if ($youtube && $youtube != NULL && $youtube->items) { // проверяем ответ, если ключ верен, видео существует и массив с информацией не пуст
            foreach ($youtube->items as $item) { // проходимся по массиву, задавая переменные
                $published   = $item->snippet->publishedAt; // дата публикации
                $title       = $item->snippet->title; // заголовок
                $description = $item->snippet->description; // описание
              //  $thumb       = $item->snippet->thumbnails; // превью
              //  $author      = $item->snippet->channelTitle; // автор видео
                $duration    = $this->ctime($item->contentDetails->duration); // продолжительность (переводим в секунды)

            }
         //   $thumb          = $yprev ? $thumb->medium->url : $thumb->default->url; // задали урл для превью видео согласно настройкам выше
            $length_min     = floor($duration / 60); // сколько целых минут
            $length_sec     = $duration % 60; // сколько секунд
            $min            = $this->getWord($length_min, $arraymin); // удобочитаемые минуты
            $sec            = $this->getWord($length_sec, $arraysec); // удобочитаемые секунды
            $title          = htmlspecialchars(trim((string)$title)); // подготовили заголовок
            $description    = !empty($description) ? htmlspecialchars(trim((string)$description)) : "Нет описания видео"; // подготовили описание, проверив на пустоту
            $time           = $length_min.''.':'.$length_sec.' '.$sec;
            $urlvideo       = 'https://www.youtube.com/watch?v='.$yurl;

            if($queueName !=null) {
                foreach ($queueName as $stop){

                    if(preg_match("/{$stop}/i", $description)) {

                        dump('record in inserted into filter'.'-'. $stop);
                        $filter = Filter::updateOrCreate(
                        ['url'  => $urlvideo],
                        [
                            'site_id'    => $site_id,
                            'title'      => $title,
                            'time'       => $time,
                            'description'=> $description,
                        ]
                    );

                    }else {

                    dump('record in inserted');
                    $pages = Page::updateOrCreate(
                        ['url'  => $urlvideo],
                        [
                            'site_id'    => $site_id,
                            'title'      => $title,
                            'time'       => $time,
                            'description'=> $description,
                        ]
                    );
                    }


                }
            }

        } else { // иначе, если произошла ошибка при парсинге
             dump('Нет данных для отображения');
        }

        }

public    function get_youtube_channel_ID($url){
        $html = file_get_contents($url);
        if($html != false) {
            preg_match("'<meta itemprop=\"channelId\" content=\"(.*?)\"'si", $html, $match);
            if ($match && $match[1]) ;
        }
        return $match[1];
    }

public function getVideoChannel($channel){

    $baseUrl   = 'https://www.googleapis.com/youtube/v3/';
    $apiKey    =  $this->apiYoutube;    //'AIzaSyCiMxifAshRCTSDNGyU6_d3bx7Skgt9TNA';
    $channelId = $channel;
    $params = [
        'id'   => $channelId,
        'part' => 'contentDetails',
        'key'  => $this->apiYoutube,
    ];
    $url = $baseUrl . 'channels?' . http_build_query($params);
    $json = json_decode(file_get_contents($url), true);

    $playlist = $json['items'][0]['contentDetails']['relatedPlaylists']['uploads'];

    $params = [
        'part'       => 'snippet',
        'playlistId' => $playlist,
        'maxResults' => '50',
        'key'        => $this->apiYoutube,
    ];
    $url  = $baseUrl . 'playlistItems?' . http_build_query($params);
    $json = json_decode(file_get_contents($url), true);

    $videos = [];
    foreach($json['items'] as $video)
        $videos[] = $video['snippet']['resourceId']['videoId'];

    while(isset($json['nextPageToken'])){
        $nextUrl = $url . '&pageToken=' . $json['nextPageToken'];
        $json    = json_decode(file_get_contents($nextUrl), true);
        foreach($json['items'] as $video)
            $videos[] = $video['snippet']['resourceId']['videoId'];
    }
    return $videos;

}

    function get_ydata($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    function getWord($number, $suffix) {
        $keys = array(2, 0, 1, 1, 1, 2);
        $modern = $number % 100;
        $suffix_key = ($modern > 7 && $modern < 20) ? 2 : $keys[min($modern % 10, 5)];
        return $suffix[$suffix_key];
    }


    function ctime($ytime) {
        $start = new DateTime("@0");
        try {
            $start->add(new DateInterval($ytime));
        } catch (\Exception $e) {
        }
        $stime = $start->format("H:i:s");
        $sc = explode(":", $stime);
        return $sc[0]*3600+$sc[1]*60+$sc[2];
    }

}
