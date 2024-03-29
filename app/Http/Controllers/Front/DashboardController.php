<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ProfileRequest;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * User profile page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        return view('front.auth.profile');
    }

    /**
     * Update user data
     *
     * @param   ProfileRequest  $profileRequest
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profile(ProfileRequest $profileRequest)
    {
        $result = null;
        $user   = auth('web')->user();
        $data   = $profileRequest->all();

        if ( ! $data['password'] && ! $data['avatar-image']) {
            return back()->withErrors(['msg' => 'Update error']);
        }

        if ($profileRequest->file('avatar-image')) {
            //            $path = $profileRequest->file('avatar-image')
            //                ->store('avatars', ['disk' => 'public']);

            $result = $user->addMedia($profileRequest->file('avatar-image'))
                ->toMediaCollection('avatars');

            if ( ! $result) {
                return back()->withErrors(['msg' => 'Update avatar error']);
            }
        }

        if ($data['password']) {
            $result = $user->update(['password' => bcrypt($data['password'])]);

            if ( ! $result) {
                return back()->withErrors(['msg' => 'Update password error']);
            }
        }

        if ($result) {
            return back()->with(['success' => 'Update success']);
        } else {
            return back()->withErrors(['msg' => 'Update error']);
        }
    }

    public function user_posts()
    {
        $posts = $this->postService->getAllUserWithPaginate(6);

        return view('front.auth.user_posts', [
            'posts' => $posts,
        ]);
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications;

        //        dd(auth()->user()->notifications);
        return view('front.auth.admin_notifications', [
            'notifications' => $notifications,
        ]);
    }

    public function notification_read($id)
    {
        auth()->user()->unreadNotifications()->find($id)->markAsRead();
        return back()->with(['success' => 'Update success']);
    }
}
