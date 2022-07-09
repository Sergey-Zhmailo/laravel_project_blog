<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\LoginRequest;
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
            return redirect('/');
        }

        return redirect(route('login'))->withErrors(['msg' => 'Error'])->withInput();
    }
}
