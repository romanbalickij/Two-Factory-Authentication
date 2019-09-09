<?php


namespace App\Traits;


use App\Models\Advertisement;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Curl\MultiCurl;
use KubAT\PhpSimple\HtmlDomParser;
use phpQuery;


trait TraitCraigslist
{


    public function curl($url) {

        $agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36';
        $config = '/tmp/cookies.txt';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $config);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $config);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $mas_html = curl_exec($ch);
        curl_close($ch);
        return $mas_html;

    }

    public function  getContentHtmlDom($url) {

        $mas_html = $this->curl($url);
        $dom = HtmlDomParser::str_get_html($mas_html);
        return $dom;
    }

    public function getCityList($html){

        $start = $html->find('section[class="body"]', 0);
        $urls = [];

        foreach ($start->find('h1') as $country) {

            $countryId = Country::createCountry($country->text());

            foreach ($country->next_sibling()->find('h4') as $state) {

                $stateId = State::createState($state->text(), $countryId);

                foreach ($state->next_sibling()->find('li a') as $cities) {

                    $cityId = City::createCity($cities->text(), $stateId);

                   $urls[$cityId] = $cities->href;

                }
            }
        }
        return $urls;
    }


    public function storeStatistics($urls){


        foreach ($urls as $id => $linkPagesHousing) {

            $englishLink = $linkPagesHousing . '?lang=en&cc=us';


            $mas_html = $this->curl($englishLink);
            $dom = phpQuery::newDocument($mas_html);
            $housings = $dom->find('div[class="housing"] ul[id="hhh0"] ');
            $links = $housings->find('a');

            $data = [];
            foreach ($links as $link) {
                $pqLink = pq($link); //pq делает объект phpQuery
                $data[$pqLink->attr('href')] = $pqLink->text();
            }


            /**getServicesLeft*/
            $servicesLeft = $dom->find('div[class="community"] ul[id="bbb0"]');
            $linksServices = $servicesLeft->find('a');
            foreach ($linksServices as $linksService) {
                $service = pq($linksService);
                $data[$service->attr('href')] = $service->text();
            }

            /**getServicesLeft*/
            $servicesRight = $dom->find('div[class="community"] ul[id="bbb1"]');
            $linksServicesRight = $servicesRight->find('a');
            foreach ($linksServicesRight as $linkServiceRight) {
                $serviceRight = pq($linkServiceRight);
                $data[$serviceRight->attr('href')] = $serviceRight->text();
            }

            /**count the number of ads */
            foreach ($data as $key => $value) {
                $prepareLink = ltrim($key, '/');
                $url[] = $linkPagesHousing . $prepareLink;




                $mas_htmls = $this->multiCurl($url);
                $doms = phpQuery::newDocument($mas_htmls);

                preg_match_all('#<span[^<>]*>([\d,]+).*?</span>#', $doms->html(), $match);

                if (isset($match[1][8])) {
                    $count = $match[1][8];
                } else {
                    $count = 0;
                }

                $data = [
                    'title' => trim($value, ' '),
                    'quantity' => $count,
                    'city_id' => $id
                ];

               // Advertisement::updateOrCreate($data);
                dump($data);
               // dump($data);
            }

            phpQuery::unloadDocuments();

        }
    }

    public  function multiCurl($data) //Многопоточная загрузка данных
    {
        $time1=time();
        $curls = array();
        // Массив дескрипторов. Библиотека создает много экземпляров своего
        // механизма, но работать они будут параллельно

        $result = array();
        //массив с результатами запрошенных страниц которые наша функция вернет.

        $mh = curl_multi_init();
        // Дескриптор мульти потока. Тоесть эта штука отвечает за то, чтобы много
        // запросов шли параллельно.

        $uagent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8";

        $header[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
        $header[] = "Accept-Language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3";
        $header[] = "Accept_charset: windows-1251,utf-8;q=0.7,*;q=0.7";
        $header[] = "Accept_encoding: gzip,deflate";
        $header[] = "Keep_alive: 300";
        $header[] = "Connection: keep-alive";

        foreach ($data as $IdRequest => $DataRequest) //Создание потока для закачки
        {
            $curls[$IdRequest] = curl_init(); // Для каждого url создаем отдельный curl механизм чтоб посылал запрос)

            curl_setopt($curls[$IdRequest], CURLOPT_URL, $DataRequest);
            curl_setopt($curls[$IdRequest], CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($curls[$IdRequest], CURLOPT_HEADER, 0);

            curl_setopt($curls[$IdRequest], CURLOPT_HTTPHEADER , $header);
            curl_setopt($curls[$IdRequest], CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
            curl_setopt($curls[$IdRequest], CURLOPT_ENCODING, "");        // обрабатывает все кодировки
            curl_setopt($curls[$IdRequest], CURLOPT_USERAGENT, $uagent);  // useragent
            curl_setopt($curls[$IdRequest], CURLOPT_CONNECTTIMEOUT, 25); // таймаут соединения
            curl_setopt($curls[$IdRequest], CURLOPT_TIMEOUT, 25);        // таймаут ответа

            curl_setopt($curls[$IdRequest], CURLOPT_FOLLOWLOCATION, 0);   // переходит по редиректам
            //curl_setopt($curls[$IdRequest], CURLOPT_MAXREDIRS, 1);        // останавливаться после 1-ого редиректа

            // добавляем текущий механизм к числу работающих параллельно
            curl_multi_add_handle($mh, $curls[$IdRequest]);
        }

        // число работающих процессов.
        $running = null;
        $time2=time();
        // curl_mult_exec запишет в переменную running количество еще не завершившихся
        // процессов. Пока они есть - продолжаем выполнять запросы.
        do
        {
            curl_multi_exec($mh, $running);
            usleep(50);
        } while($running > 0);

        // Собираем из всех созданных механизмов результаты, а сами механизмы удаляем
        foreach($curls as $id => $c)
        {
            $result[$id] = curl_multi_getcontent($c);
            curl_multi_remove_handle($mh, $c);
        }
        $time3=time()-$time2;
        // Освобождаем память от механизма мультипотоков
        curl_multi_close($mh);


        ksort($result);
        return $result;


    }


}
// https://habr.com/ru/post/68175/
