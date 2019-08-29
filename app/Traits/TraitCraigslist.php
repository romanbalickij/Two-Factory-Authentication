<?php


namespace App\Traits;


use App\Models\Advertisement;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use KubAT\PhpSimple\HtmlDomParser;


trait TraitCraigslist
{

    public function  getContent($url) {
        $agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36';
        $config = '/tmp/cookies.txt';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $config);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $config);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $mas_html = curl_exec($ch);
        curl_close($ch);
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

            $englishLink = $linkPagesHousing.'?lang=en&cc=us';








            $dom = $this->getContent($englishLink);
            /**getHousing**/
            $housings = $dom->find('div[class="housing"] ul[id="hhh0"] li a');
            $data = [];
            foreach ($housings as $housing) {
                $data[$housing->href] = $housing->text();
            }
            /**getServicesLeft*/
            $servicesLeft = $dom->find('div[class="community"] ul[id="bbb0"] li a');
            foreach ($servicesLeft as $service) {
                $data[$service->href] = $service->text();
            }
            /**getServicesRight*/
            $servicesRight = $dom->find('div[class="community"] ul[id="bbb1"] li a');
            foreach ($servicesRight as $serviceRight) {
                $data[$serviceRight->href] = $serviceRight->text();
            }

            /**count the number of ads */
            foreach ($data as $key => $value) {
                $prepareLink = ltrim($key,'/');
                $url =  $linkPagesHousing.$prepareLink;
              //  dump($url);

//                $dom = $this->getContent($url);
                $context = stream_context_create(
                    array(
                        'http' => array(
                            'max_redirects' => 101,
                            'ignore_errors' => true
                        )
                    )
                );
                $html = file_get_contents($url, false, $context);
                $doms = HtmlDomParser::str_get_html($html);
                  /**здесь прроблема  */
                $count = $doms->find('span[class="totalcount"]', 0) == null ? '0' : $doms->find('span[class="totalcount"]', 0)->text();


                $data = [
                    'title'    => trim($value,' '),
                    'quantity' => $count,
                    'city_id'  => $id
                ];

                Advertisement::updateOrCreate($data);
                dump('Advertisement save ');
            }
        }
    }

    public function multiCurl($urls)
    {
        $multi = curl_multi_init();
        $handles = [];

        foreach ($urls as $url ) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($multi, $ch);
            $handles[$url] = $ch;
        }

        do {
            $mcr = curl_multi_exec($multi, $active);

        }while($mcr = CURLM_CALL_MULTI_PERFORM);

        while ($active && $mcr == CURLM_OK)
        {
            if (curl_multi_select($multi) == -1)
            {
                usleep(100);
            }
            do
            {
                $mcr = curl_multi_exec($multi, $active);

            }while($mcr == CURLM_CALL_MULTI_PERFORM);
        }

        foreach ($handles as $channel) {
            $html = curl_multi_getcontent($channel);
            dump($html);
            curl_multi_remove_handle($multi, $channel);

        }

        curl_multi_close($multi);

    }


}
