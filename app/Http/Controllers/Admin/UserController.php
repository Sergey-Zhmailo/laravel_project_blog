<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('front.auth.admin_dashboard');
    }

    /**
     * Create new user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $user = new User();

        return view('admin.auth.user_edit', [
            'post' => $user,
        ]);
    }

    /**
     * Store new user
     *
     * @param   \App\Http\Requests\Admin\UserCreateRequest  $userCreateRequest
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserCreateRequest $userCreateRequest)
    {
        $this->authorize('create', User::class);

        $user = User::create([
            'name'     => $userCreateRequest->validated('name'),
            'email'    => $userCreateRequest->validated('email'),
            'password' => bcrypt($userCreateRequest->validated('password')),
        ]);

        if (!$user) {
            return back()
                ->withErrors(['msg' => 'Creation error'])
                ->withInput();
        }

        return redirect()
            ->route('admin.users')
            ->with([
                'success' => 'Success! User was created',
            ]);
    }

    /**
     * Edit user
     *
     * @param   int  $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $this->authorize('update', User::class);

        $user = User::query()
            ->findOrFail($id);

        return view('admin.auth.user_edit', [
            'post' => $user,
        ]);
    }

    /**
     * Update user
     *
     * @param   \App\Http\Requests\Admin\UserUpdateRequest  $userUpdateRequest
     * @param   int  $id
     *
     * @return void
     */
    public function update(UserUpdateRequest $userUpdateRequest, int $id)
    {
        //если есть пароль то пересоздать и сохранить
        $this->authorize('update', User::class);

        $user = User::query()
            ->find($id);

        $data               = $userUpdateRequest->validated();
        $data['password']   = bcrypt($userUpdateRequest->validated('password'));
        $data['is_blocked'] = boolval($userUpdateRequest->get('is_published'));
        $data['is_api']     = boolval($userUpdateRequest->get('is_api'));

        $result = $user->update($data);

        if ( ! $result) {
            return back()
                ->withErrors(['msg' => 'Update error'])
                ->withInput();
        }

        return redirect()
            ->route('admin.users.edit', $id)
            ->with(['success' => 'Update success']);
    }

    /**
     * Delete user
     *
     * @param   int  $id
     *
     * @return void
     */
    public function delete(int $id)
    {
        $this->authorize('delete', User::class);
        $user = User::findOrFail($id);

        $result = $user->delete($id);

        if ( ! $result) {
            return back()
                ->withErrors(['msg' => 'Delete error']);
        }

        return back()
            ->with(['success' => 'User success deleted']);
    }

    public function users()
    {
        $users = User::query()
            ->whereNot('role_id', '=', Role::IS_ADMIN)
            ->orderBy('id', 'asc')
            ->paginate(3);

        //        dd($users);
        return view('front.auth.admin_users', [
            'posts' => $users,
        ]);
    }

    public function block_user($id)
    {
        //        $this->authorize('admin_actions');
        $this->authorize('block', User::class);

        $user = User::query()
            ->findOrFail($id);

        $result = $user->update(['is_blocked' => true]);

        if (!$result) {
            return back()->withErrors(['msg' => 'User ban error']);
        }

        return back()->with(['success' => 'User blocked']);
    }

    public function unblock_user($id)
    {
        $this->authorize('block', User::class);

        $user = User::query()
            ->findOrFail($id);

        $result = $user->update(['is_blocked' => false]);

        if ( ! $result) {
            return back()->withErrors(['msg' => 'User unblock error']);
        }

        return back()->with(['success' => 'User ublocked']);
    }
}
