<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Requests\{UserStoreRequest, UserUpdateRequest};

class UserController
{
    public function index() {
        $users = User::visitors()->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $user = User::with('images')->findOrFail($id);
        return response()->json($user);
    }

    /**
     * @param UserStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
        User::create($request->all());
        return response()->json(User::visitors()->get());
    }

    /**
     * @param UserUpdateRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request, int $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->has('password')) {
            $user->password = $request->password;
        }

        $user->save();

        return response()->json(User::visitors()->get());
    }

    /**
     * @param int $id
     */
    public function destroy(int $id)
    {
        User::destroy($id);
    }
}