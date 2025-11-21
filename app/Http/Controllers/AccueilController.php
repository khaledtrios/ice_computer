<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccueilController extends Controller
{
      public function index()
    {
      return redirect('login');
       return view('front-office.accueil.index', ["index"=>true, "tarif"=>false, "contact"=>false]);
    }
    public function tarif()
    {
       return view('front-office.accueil.tarif', ["index"=>false, "tarif"=>true, "contact"=>false]);

    }
    public function contact()
    {
       return view('front-office.accueil.contact', ["index"=>false, "tarif"=>false, "contact"=>true]);
    }

}

