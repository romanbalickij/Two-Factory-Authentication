<?php

namespace App\Console\Commands;


use App\Exports\InvoicesExport;
use App\Intims;
use App\Massage;
use App\Models\Advertisement;

use App\Traits\TraitCraigslist;

use DOMDocument;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use KubAT\PhpSimple\HtmlDomParser;




use Maatwebsite\Excel\Facades\Excel;
use phpQuery;


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


        $agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36';
        $config = '/tmp/cookies.txt';
        $ch = curl_init('http://k.intimstory.com/type0/style0/');
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

        for($i = 0; $i <= $maxNumberPaginator; $i++) {
            $link = 'http://k.intimstory.com/type0/style0/?page=' . $i;

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
                        'name' => $intiname,
                        'phone' => $filterPhone,
                    ];

                    dump($data);
                    Intims::updateOrCreate(
                        ['phone'  => $filterPhone],
                        [
                            'name'    => $intiname,
                        ]);

                }
                }

            }

    }


//$dom = new DOMDocument();
//@$dom->loadHTML($mas_html);
//$xPath = new DOMXPath($dom);
//$elements = $xPath->query("//a/@href");
//foreach ($elements as $e) {
//dump( $e->nodeValue);
//}

    function getNumbers($params) {
        $res = array();
        $str = preg_replace("/[^1-9]/", " ",  $params);
        $str = trim(preg_replace('/\s+/u', ' ', $params));
        $arr = explode(' ', $str);
        for ($i = 0; $i < count($arr); $i++) {
            if (is_numeric($arr[$i])) {
                $res[] = $arr[$i];
            }
        }
        return $res ;
    }

    public function crawl_page1($url, $depth = 5)
    {
        static $seen = array();
        if (isset($seen[$url]) || $depth === 0) {
            return;
        }

        $seen[$url] = true;

        $dom = new DOMDocument();
        @$dom->loadHTMLFile($url);
        $xpath = new DOMXPath($dom);
        $articles = $xpath->query('//div[@class="storyLeft adp_edin_ank "]');
        foreach ($articles as $article) {
            $anchors = $article->getElementsByTagName('a');
            foreach ($anchors as $element) {
                $href = $element->getAttribute('href');
                if (0 !== strpos($href, 'http')) {
                    $path = '/' . ltrim($href, '/');
                    if (extension_loaded('http')) {
                        $href = http_build_url($url, array('path' => $path));
                    } else {
                        $parts = parse_url($url);
                        $href = $parts['scheme'] . '://';

                        if (isset($parts['user']) && isset($parts['pass'])) {
                            $href .= $parts['user'] . ':' . $parts['pass'] . '@';
                        }
                        $href .= $parts['host'];
                        if (isset($parts['port'])) {
                            $href .= ':' . $parts['port'];
                        }
                        $href .= $path;

                    }
                }
                $this->crawl_page1($href, $depth - 1);
            }
        }


        // Site::updateOrCreate(['url' => $url, 'status' => 200, 'isCrawled' => false]);
      //  dump($url);

    }

    function crawl_page($url, $depth = 5)
    {
        static $seen = array();
        if (isset($seen[$url]) || $depth === 0) {
            return;
        }

        $seen[$url] = true;

        $dom = new DOMDocument('1.0');
        @$dom->loadHTMLFile($url);

        $anchors = $dom->getElementsByTagName('a');
        foreach ($anchors as $element) {
            $href = $element->getAttribute('href');
            if (0 !== strpos($href, 'http')) {
                $path = '/' . ltrim($href, '/');
                if (extension_loaded('http')) {
                    $href = http_build_url($url, array('path' => $path));
                } else {
                    $parts = parse_url($url);
                    $href = $parts['scheme'] . '://';
                    if (isset($parts['user']) && isset($parts['pass'])) {
                        $href .= $parts['user'] . ':' . $parts['pass'] . '@';
                    }
                    $href .= $parts['host'];
                    if (isset($parts['port'])) {
                        $href .= ':' . $parts['port'];
                    }
                    $href .= dirname($parts['path'], 1) . $path;
                }
            }
            $this->crawl_page($href, $depth - 1);
        }

        dump($url);

    }

    public function phone($value)
    {
        $result = false;
        str_replace(' ','',$value);//отбросим пробелы

        if ( $rez = preg_match_all('~\A\D*(?:\+7|8)(?:\D*\d){10}\D*\z~',$value))
          $result = true;
        return $result;
    }

}

