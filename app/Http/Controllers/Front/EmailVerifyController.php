<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    public function index()
    {
        return view('front.auth.verify-email');
    }

    /**
     * @param EmailVerificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('home');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }
}
