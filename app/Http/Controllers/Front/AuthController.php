<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\LoginRequest;
use App\Http\Requests\Front\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('front.auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (auth('web')->attempt($request->validated())) {
            return redirect('/')->with(['success' => 'Success! Welcome']);
        }

        return redirect(route('login'))->withErrors(['msg' => 'Login error, check login and password'])->withInput();
    }

    public function showRegisterForm()
    {
        return view('front.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->validated('nickname'),
            'email' => $request->validated('email'),
            'password' => bcrypt($request->validated('password')),
        ]);

        if ($user) {
            // Email confirm
            event(new Registered($user));

            auth('web')->login($user);

            return redirect()->route('verification.notice')->with(['success' => 'Success! Please check your mail
            and confirm verification']);
        }

        return back()->withErrors(['msg' => 'Rigistration error'])->withInput();
    }

    public function logout()
    {
        auth('web')->logout();

        return redirect(route('home'))->with(['info' => 'Your are logged out!']);
    }
}
