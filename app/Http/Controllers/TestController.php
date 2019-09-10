<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;
use Clue\React\Buzz\Browser;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Factory;

class TestController extends Controller
{
    public function index(){

        $loop = Factory::create();
        $client = new Browser($loop);

        $client->get('https://phpprofi.ru/blogs/post/101')
            ->then(function(ResponseInterface $response) {
                   $dom  = \phpQuery::newDocument($response->getBody());

                   dump($dom);
            });

    }


}
