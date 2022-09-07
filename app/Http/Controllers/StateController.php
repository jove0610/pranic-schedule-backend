<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateStoreRequest;
use App\Http\Requests\StateUpdateRequest;
use App\Models\State;

class StateController extends Controller
{
    public function index()
    {
        $states = State::all();
        return response()->json($states);
    }

    public function store(StateStoreRequest $request)
    {
        $state = $request->validated();
        State::create($state);
        return response()->noContent();
    }

    public function show(int $id)
    {
        $state = State::find($id);
        return is_null($state) ? abort(404, 'Not Found') : response()->json($state);
    }

    public function update(StateUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $state = State::find($id);

        if (is_null($state)) {
            return abort(404, 'Not Found');
        }
        foreach ($data as $key => $value) {
            $state[$key] = $value;
        }

        $state->save();
        return response()->noContent();
    }

    public function destroy(int $id)
    {
        $isDeleted = State::destroy($id);
        return $isDeleted ? response()->noContent() : abort(404, 'Not Found');
    }
}
