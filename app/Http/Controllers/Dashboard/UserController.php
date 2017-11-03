<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\User;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controller;


class UserController extends Controller
{
    public function index(Request $request) {
        $response = [
            'users' => User::all(),
            'permissions' => Auth::user()->getAllPermissions()
        ];
        return $response;
    }
}
