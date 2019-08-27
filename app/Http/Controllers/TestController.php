<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;


class TestController extends Controller
{
    public function index(){

        $html = file_get_contents('https://www.craigslist.org/about/sites');
        $dom = HtmlDomParser::str_get_html($html);
    }
}
