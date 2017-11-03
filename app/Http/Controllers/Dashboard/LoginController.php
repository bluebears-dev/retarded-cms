<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Validator;
use Auth;
use Lang;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     *
     */
    private $rules = null;

    public function __construct(Guard $auth)

    {
        $this->rules = [
            'login' => 'required:users.login',
            'password' => 'required:users.password'
        ];

        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showForms()
    {
        return view('rcms.login.index');
    }

    protected function redirectWithErrors(Request $request, $errors)
    {
        if ($request->ajax()) {
            return response()->json($errors);
        }
        return redirect()->back()->withErrors($errors);
    }

    protected function redirectAuthorizedUser(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['redirect' => route('rcms')]);
        }
        return redirect()->intended(route('rcms'));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails())
            return $this->redirectWithErrors($request, $validator->messages());

        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectAuthorizedUser($request);
        }
        return $this->redirectWithErrors($request, ['authorization' => [Lang::get('auth.failed')]]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        Cache::flush();

        return redirect()->intended('/login');
    }

    public function username()
    {
        return 'login';
    }
}
