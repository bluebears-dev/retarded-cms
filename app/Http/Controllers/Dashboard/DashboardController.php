<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Theme;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function index()
    {
        return view('rcms.dashboard.index');
    }

    public function themes() {
        return $this->createResponse(Theme::all('name', 'colors'), Response::HTTP_OK);
    }
}
