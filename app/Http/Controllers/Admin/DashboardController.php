<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
//        dd(__METHOD__);
        return view('front.auth.admin_dashboard', [

        ]);
    }

    public function users()
    {
        $users = User::query()
            ->whereNot('is_admin', '=', true)
            ->orderBy('id', 'asc')
            ->paginate(3);
//        dd($users);
        return view('front.auth.admin_users', [
            'posts' => $users
        ]);
    }

    public function block_user($id)
    {
//        $this->authorize('admin_actions');
        $this->authorize('block', User::class);

        $user = User::query()->findOrFail($id);

        $result = $user->update(['status' => 0]);

        if ($result) {
            return back()->with(['success' => 'User blocked']);
        } else {
            return back()->withErrors(['msg' => 'User ban error']);
        }
    }

    public function unblock_user($id)
    {
        $this->authorize('block', User::class);

        $user = User::query()->findOrFail($id);

        $result = $user->update(['status' => 1]);

        if ($result) {
            return back()->with(['success' => 'User ublocked']);
        } else {
            return back()->withErrors(['msg' => 'User unblock error']);
        }
    }
}
