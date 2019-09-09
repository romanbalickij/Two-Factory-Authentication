<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Country;

use App\Traits\TraitCraigslist;
use GuzzleHttp\Client;
use Illuminate\Console\Command;



class ParserCraigslist extends Command
{

    use TraitCraigslist ;
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
        $url  = 'https://www.craigslist.org/about/sites';
        $dom  = $this->getContentHtmlDom($url);
        $urls = $this->getCityList($dom);
        $this->storeStatistics($urls);




    }


}


