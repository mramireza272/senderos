<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ImeiUser;
use App\DeliveryTeam;
use App\LocationTmp;
use App\User;
use Carbon\Carbon;
use App\Path;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function menu(){
        return \View::make('home');
    }

}
