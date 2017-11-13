<?php
/**
 * User: pgorski42
 * Date: 14.11.17
 * Time: 00:08
 */

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class RCMSController extends Controller
{
    protected function createResponse($data, $code)
    {
        return response()->json($data)->setStatusCode($code, Response::$statusTexts[$code]);
    }
}
