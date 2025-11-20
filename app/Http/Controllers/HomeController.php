<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::user()->hasRole('superadmin')) {
            return redirect()->route('superadmin.boutiques.list');
        } elseif (Auth::user()->hasRole('boutique')) {
            return redirect()->route('boutique.configuration');
        }
        Auth::logout();
        return redirect()->route('login');
    }

}
