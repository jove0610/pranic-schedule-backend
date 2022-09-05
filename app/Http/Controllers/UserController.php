<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();
        return response()->json($users);
    }

    public function store(UserStoreRequest $request)
    {
        $user = $request->validated();
        User::create($user);
        return response()->noContent();
    }

    public function show(int $id)
    {
        $user = User::find($id);
        return is_null($user) ? abort(404, 'Not Found') : response()->json($user);
    }

    public function update(UserUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $user = User::find($id);

        if (is_null($user)) {
            return abort(404, 'Not Found');
        }
        foreach ($data as $key => $value) {
            $user[$key] = $value;
        }

        $user->save();
        return response()->noContent();
    }

    public function destroy(int $id)
    {
        $isDeleted = User::destroy($id);
        return $isDeleted ? response()->noContent() : abort(404, 'Not Found');
    }
}
