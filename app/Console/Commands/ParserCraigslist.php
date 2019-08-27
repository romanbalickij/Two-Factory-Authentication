<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use KubAT\PhpSimple\HtmlDomParser;

class ParserCraigslist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:craigslist';

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
        $client = new Client();
        $response = $client->request('GET', $url);
        $response_status_code = $response->getStatusCode();
        $html = $response->getBody()->getContents();
        $dom = HtmlDomParser::str_get_html($html);

        $mainPage = $dom->find('section[class="body"]', 0);

        $urls = [];
        foreach ($mainPage->find('h1 ') as $searchCountry) {


            $countryId = Country::createCountry($searchCountry->text());



            foreach ($mainPage->find('div[class="colmask"]') as $findCategory) {

                foreach ($findCategory->children() as $category) {

                    foreach ($category->find('h4') as $title) {



                      $stateId = State::createState($category = $title->text(), $countryId);

                        foreach ($title->next_sibling()->find('li a ') as $subcategory) {


                            $parseUrl = str_replace(' ', '', $subcategory->href);
                            $urls[] = $subcategory->href;

                               City::createCity($subcategory->text(),$stateId);

                        }
                    }
                }
            }
        }

    }


    /* парсинг второго потока  housing  service  **/
    public function parserPages( $url) {

        foreach ($url as $link) {

            $context = stream_context_create(
                array(
                    'http' => array(
                        'max_redirects' => 101
                    )
                )
            );
            $html = file_get_contents($link, false, $context);
            $dom = HtmlDomParser::str_get_html($html);

            $cities = explode(',', $dom->find('div[class="regular-area"] h2', 0)->text()); // cities[0]
            $housings = $dom->find('div[class="housing"] ul[id="hhh0"] li a');

            $data = [];
            foreach ($housings as $housing) {
                $data[$housing->href] = $housing->text();
            }


            $servicesLeft = $dom->find('div[class="community"] ul[id="bbb0"] li a');
            foreach ($servicesLeft as $service) {
                $data[$service->href] = $service->text();
            }

            $servicesRight = $dom->find('div[class="community"] ul[id="bbb1"] li a');
            foreach ($servicesRight as $serviceRight) {

                ///*цю дату можна передавати на інший етап а там вже проходитись по ній** ///
                $data[$serviceRight->href] = $serviceRight->text();
            }

        }
        dump($data);


    }


    /***
     *
     * нужно будет создать ищо одну базу допустим post
     *    поле  где будет вставлятся  назва housing services
     *  поле  количество постов  в даних силках
     * поле city_id   к которому принадлежит
     *
     *
    ***/
}
