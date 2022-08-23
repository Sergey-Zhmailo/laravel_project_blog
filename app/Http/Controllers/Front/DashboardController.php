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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
//        dd(auth('web')->user()->getFirstMedia('avatars')->getPath('thumb'));
        return view('front.auth.profile');
    }

    /**
     * Update user data
     * @param ProfileRequest $profileRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function profile(ProfileRequest $profileRequest)
    {
        $result = null;
        $user = auth('web')->user();
        $data = $profileRequest->all();

        if (!$data['password'] && !$data['avatar-image']) {
            return back()->withErrors(['msg' => 'Update error']);
        }

        if ($profileRequest->file('avatar-image')) {
//            $path = $profileRequest->file('avatar-image')
//                ->store('avatars', ['disk' => 'public']);

            if ($user->image != null) {
                Storage::delete($user->image);
            }

            $result = $user->addMedia($profileRequest->file('avatar-image'))->toMediaCollection('avatars');

//            if ($path) {
//                $result = $user->update(['image' => $path]);
//            }

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

    public function user_posts()
    {
        $posts = $this->postService->getAllUserWithPaginate(6);

        return view('front.auth.user_posts', [
            'posts' => $posts
        ]);
    }
}
