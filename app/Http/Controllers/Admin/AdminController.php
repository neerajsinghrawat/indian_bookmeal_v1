<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth:admin');
        //$setting = Setting::first();
        //echo '<pre>';print_r($setting);die;
        //@extends('layouts.admin',['settings' => $setting]);
             
    }

	

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //echo "string";die();
        return view('admin.pages.dashboard');
    }
}