<?php

namespace App\Console\Commands;

use App\Exports\InvoicesExport;
use App\Massage;
use DOMDocument;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use phpQuery;

class ParserMassage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:massage';

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


        $agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36';
        $config = '/tmp/cookies.txt';
        $ch = curl_init('http://k.intimstory.com/type1/style0/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $config);
        curl_setopt($ch, CURLOPT_COOKIE, $config);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $config);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $mas_html = curl_exec($ch);
        curl_close($ch);

        $dom = new DOMDocument();
        @$dom->loadHTML($mas_html);
        $xpath = new DOMXPath($dom);
        $articles = $xpath->query('//div[@class="pagingList"]');
        foreach ($articles as $article) {
            $anchors = $article->getElementsByTagName('a');
            foreach ($anchors as $element) {
                $link  =  $href = $element->getAttribute('href');

                $paginator[] = preg_replace("/[^1-9]/", '',$link );



            }
        }

        $maxNumberPaginator = max($paginator);



        for ($i = 0; $i <= $maxNumberPaginator; $i++) {
            $link = 'http://k.intimstory.com/type1/style0/?page=' . $i;

            $agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36';
            $config = '/tmp/cookies.txt';
            $ch = curl_init($link);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $config);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $config);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $mas_html = curl_exec($ch);
            curl_close($ch);

            $dom = new DOMDocument();
            @$dom->loadHTML($mas_html);
            $xpath = new DOMXPath($dom);
            $articles = $xpath->query('//div[@class="infoRight"]');
            foreach ($articles as $article) {
                $anchors = $article->getElementsByTagName('a');
                foreach ($anchors as $element) {
                    $href = $element->getAttribute('href');
                    $prepareUrl = 'http://k.intimstory.com/' . $href;


                    $agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36';
                    $config = '/tmp/cookies.txt';
                    $ch = curl_init($prepareUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
                    curl_setopt($ch, CURLOPT_COOKIEJAR, $config);
                    curl_setopt($ch, CURLOPT_COOKIEFILE, $config);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    $mas_html = curl_exec($ch);
                    curl_close($ch);

                    $dom = phpQuery::newDocument($mas_html);
                    $name = $dom->find('h1[class="breadcrumbs"] span');
                    $intiname = $name->text();
                    $phone = $dom->find('p[class="t"] a ');

                    preg_match_all('/(\+?[\d-\(\)\s]{8,20}[0-9]?\d)/', $phone->text(), $matches);
                    if (isset($matches[0][0])) {
                        $filterPhone = $matches[0][0];
                    } else {
                        $filterPhone = 'телефон нет';
                    }


                    $data = [
                        'name'  => $intiname,
                        'phone' => $filterPhone,
                    ];

                    dump($data);

                    Massage::updateOrCreate(
                        ['phone'  => $filterPhone],
                        [
                            'name'    => $intiname,
                        ]);

                }
                }
            }
        }

}
