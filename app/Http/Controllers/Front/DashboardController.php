<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        return view('front.auth.profile');
    }

    public function profile(ProfileRequest $profileRequest)
    {
        $result = null;
        $user = auth('web')->user();
        dd($user->image);
        $data = $profileRequest->all();

        if (!$data['password'] && !$data['avatar-image']) {
            return back()->withErrors(['msg' => 'Update error']);
        }

        if ($profileRequest->file('avatar-image')) {
            $path = $profileRequest->file('avatar-image')->store('avatars');

            if ($path) {
                $result = $user->update(['image' => 'asd']);
                dd($user->image);
            }

            if (!$result) {
                return back()->withErrors(['msg' => 'Update avatar error']);
            }
        }

        if ($data['password']) {
            $result = $user->update(['password' => bcrypt($data['password'])]);

            if (!$result) {
                return back()->withErrors(['msg' => 'Update password error']);
            }
        }

        if ($result) {
            return back()->with(['success' => 'Update success']);
        } else {
            return back()->withErrors(['msg' => 'Update error']);
        }
    }
}
