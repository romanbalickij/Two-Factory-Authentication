<?php

namespace App\Console\Commands;

use App\Rus;
use DOMDocument;
use DOMXPath;
use Illuminate\Console\Command;
use phpQuery;

class ParseMassageRus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:rus';

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




        for ($i = 1; $i <= 36; $i++) {

            $links = 'https://rus-massage.com/list/city-122/?page='.$i;

            $agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36';
            $config = '/tmp/cookies.txt';
            $ch = curl_init($links);
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
            $articles = $xpath->query('//div[@class="more-link-wrapper"]');
            foreach ($articles as $article) {
                $anchors = $article->getElementsByTagName('a');
                foreach ($anchors as $element) {
                    $href = $element->getAttribute('href');
                    $prepareLink = "https://rus-massage.com" . $href;


                    $agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.96 Safari/537.36';
                    $config = '/tmp/cookies.txt';
                    $ch = curl_init($prepareLink);
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


                    $dom = phpQuery::newDocument($mas_html);
                    $name = $dom->find('h1[class="mt-none mb-none"]');
                    $intiname = $name->text();
                    $restname = substr($intiname, 20);
                    $trimname = trim($restname);


                    $phone = $dom->find('div[class="phone-wrapper"]');
                    $s = $phone->text();
                    $rest = substr($s, 20);
                    $trim = trim($rest);
                    $filter = substr($trim, 0, -11);


                    $data = array([
                        'name'  => $trimname,
                        'phone' => $filter,
                    ]);

                    dump($data,$prepareLink);

                    Rus::updateOrCreate(
                        ['phone'  => $filter],
                        [
                            'name'    => $trimname,
                        ]);

                }


                }


            }
        }


}
