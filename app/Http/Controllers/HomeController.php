<?php

namespace App\Http\Controllers;

use App\Content;
use App\Create;
use App\Exports\FiltersExport;
use App\Exports\IntimisExport;
use App\Exports\MassageExport;
use App\Exports\PagesExport;
use App\Exports\RusExport;
use App\Intims;
use App\Mail\FileDownloaded;
use App\Page;

use App\Site;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class HomeController extends Controller
{

    public function __construct()
    {
      //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function exportForm()
    {

        return view('welcome');
    }

    public function export()
    {
        return Excel::download(new MassageExport(), 'massage.xlsx');
    }

    public function filter()
    {
        return Excel::download( new IntimisExport(), 'ind.xlsx');
    }

    public function rus(){

        return Excel::download( new RusExport(), 'rus.xlsx');
    }






}
