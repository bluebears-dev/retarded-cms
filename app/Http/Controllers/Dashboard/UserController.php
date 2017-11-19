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
    private $rules = null;

    public function __construct(Guard $auth)
    {
        $this->rules = [
            'login' => 'required:users.login,,unique:users.login',
            'password' => 'required:users.password,min:8'
        ];
    }
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

    public function update(Request $request, $user) {
        return [$request->all(), $user];
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
