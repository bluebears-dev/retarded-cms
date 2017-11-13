<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Auth;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Validator;
use Lang;

class UserController extends RCMSController
{
    public function index() {
        $users = User::all();

        foreach ($users as $user)
            $user->getRoleNames();

        $response_data = [
            'users' => $users
        ];
        return $this->createResponse($response_data, Response::HTTP_OK);
    }

    public function store(Request $request) {

    }

    public function show(Request $request, $user) {

    }

    public function edit(Request $request, $user) {
        return $this->createResponse(['user' => $user], Response::HTTP_OK);
    }

    public function update(Request $request, $user) {

    }

    public function destroy(Request $request, $user) {
        $user = User::find($user);
        $response_data = null;
        if ($user) {
            $response_data = $user->id;
            if (Auth::user()->id == $user->id) {
                LoginController::logout($request);

                $response_data = ['redirect' => route('dashboard')];
            }
            $user->delete();
        }
        return $this->createResponse($response_data, Response::HTTP_OK);
    }

    public function current(Request $request) {
        $user = Auth::user();
        $user->getRoleNames();
        return $this->createResponse(['currentUser' => $user], Response::HTTP_OK);
    }
}
