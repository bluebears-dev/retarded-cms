<?php

namespace App\Http\Controllers\Panel;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class DashboardController extends Controller
{
    public function index()
    {
        return view('panel.dashboard.index');
    }
}
