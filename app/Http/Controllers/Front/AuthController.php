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
    /**
     * Display login page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        return view('front.auth.login');
    }

    /**
     * Login process
     *
     * @param   LoginRequest  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(LoginRequest $request)
    {
        $is_banned = User::query()
            ->where('email', '=', $request->validated('email'))
            ->where('is_blocked', '!=', false)
            ->exists(); //вернет true or false

        if ($is_banned) {
            return redirect()
                ->route('home')
                ->withErrors(['msg' => 'Your account is banned!']);
        }

        if (auth('web')->attempt($request->validated())) {
            return redirect('/')->with(['success' => 'Success! Welcome']);
        }

        return redirect(route('login'))
            ->withErrors(['msg' => 'Login error, check login and password'])
            ->withInput();
    }

    /**
     * Display register page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showRegisterForm()
    {
        return view('front.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'     => $request->validated('nickname'),
            'email'    => $request->validated('email'),
            'password' => bcrypt($request->validated('password')),
        ]);

        if ($user) {
            // Email confirm
            event(new Registered($user));

            auth('web')->login($user);

            return redirect()
                ->route('verification.notice')
                ->with([
                    'success' => 'Success! Please check your mail
            and confirm verification',
                ]);
        }

        return back()
            ->withErrors(['msg' => 'Rigistration error'])
            ->withInput();
    }

    /**
     * Logout process
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        auth('web')->logout();

        return redirect()
            ->route('home')
            ->with(['info' => 'Your are logged out!']);
    }
}
