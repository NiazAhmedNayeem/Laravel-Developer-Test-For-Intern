<?php

namespace App\Http\Controllers\Backend\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('backend.dashboard.index');
    }

    public function country(){
        return view('backend.dashboard.country');
    }
}
