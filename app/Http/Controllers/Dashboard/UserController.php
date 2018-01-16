<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Theme;
use App\User;
use Auth;
use Illuminate\Support\Facades\App;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use Lang;

class UserController extends Controller
{
    private $rules = null;
    private $pusher = null;

    public function __construct(Guard $auth)
    {
        $this->rules = [
            'login' => 'required:users.login|unique:users',
            'password' => 'required:users.password|min:8'
        ];
        $this->pusher = $pusher = App::make('pusher');
    }

    public function index()
    {
        $users = User::all();
        foreach ($users as $user)
            $user->getRoleNames();

        $response_data = [
            'users' => $users
        ];
        return $this->createResponse($response_data, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('create users')) {
            $validator = Validator::make($request->all(), $this->rules);

            if ($validator->fails())
                return $this->createResponse($validator->messages(), Response::HTTP_BAD_REQUEST);
            $request->merge(['password' => bcrypt($request->password)]);

            $user = User::create($request->only('login', 'password'));
            $user->assignRole($request->role);
            $user->save();
            $this->pusher->trigger('user-management-channel', 'user-change-event', []);
            return $this->createResponse($user, Response::HTTP_OK);
        }
        return $this->createResponse('', Response::HTTP_FORBIDDEN);
    }

    public function show(Request $request, $user)
    {

    }

    public function update(Request $request, $user)
    {
        if (Auth::user()->can('edit users')) {
            $user = User::find($user);
            if ($user) {
                $user->syncRoles($request->only('role'));
                $this->pusher->trigger('user-management-channel', 'user-role-event', [$user->login => $request->role]);
            }
        }
    }

    public function destroy(Request $request, $user)
    {
        if (Auth::user()->can('delete users')) {
            $user = User::find($user);
            $response_data = null;
            if ($user) {
                $response_data = $user->id;
                if (Auth::user()->id == $user->id) {
                    LoginController::logout($request);

                    $response_data = ['redirect' => route('dashboard')];
                }
                $user->delete();
                $this->pusher->trigger('user-management-channel', 'user-change-event', []);
            }
            return $this->createResponse($response_data, Response::HTTP_OK);
        }
        return $this->createResponse('', Response::HTTP_FORBIDDEN);
    }

    public function current(Request $request)
    {
        $user = Auth::user();
        $user->getRoleNames();
        return $this->createResponse(['currentUser' => $user], Response::HTTP_OK);
    }

    public function roles(Request $request)
    {
        $data = Role::all('name');
        return $this->createResponse(['roles' => $data], Response::HTTP_OK);
    }

    public function theme(Request $request)
    {
        $user = Auth::user();
        $user->theme = Theme::where('name', $request->only('name'))->pluck('path')[0];
        $user->save();

        return $this->createResponse('', Response::HTTP_OK);
    }
}
