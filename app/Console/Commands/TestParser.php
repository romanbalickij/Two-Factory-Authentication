<?php

namespace App\Console\Commands;

use App\Jobs\TestParercraiglist;
use App\Models\Advertisement;
use App\Traits\Craigslist;
use App\Traits\TraitCraigslist;
use Curl\MultiCurl;
use Illuminate\Console\Command;
use KubAT\PhpSimple\HtmlDomParser;


class TestParser extends Command
{
    use TraitCraigslist;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

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

        $url = 'https://www.craigslist.org/about/sites';
        $dom = $this->getContentHtmlDom($url);
        $urls = $this->getCityList($dom);
        $reverse = array_reverse($urls,true);

        foreach ($reverse as $id => $linkPagesHousing) {

            $englishLink = $linkPagesHousing . '?lang=en&cc=us';


            $agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36';
            $config = '/tmp/cookies.txt';
            $ch = curl_init($englishLink);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, $agent);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $config);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $config);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $mas_html = curl_exec($ch);
            curl_close($ch);

            $dom = \phpQuery::newDocument($mas_html);
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
                $url = $linkPagesHousing . $prepareLink;


                $agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36';
                $config = '/tmp/cookies.txt';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, $agent);
                curl_setopt($ch, CURLOPT_COOKIEJAR, $config);
                curl_setopt($ch, CURLOPT_COOKIEFILE, $config);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $mas_htmls = curl_exec($ch);
                curl_close($ch);

                $doms = \phpQuery::newDocument($mas_htmls);
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

              //  Advertisement::updateOrCreate($data);
                dump($data);
            }


            \phpQuery::unloadDocuments();
        }
    }
}
