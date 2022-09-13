<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfficeIndexRequest;
use App\Http\Requests\OfficeStoreRequest;
use App\Http\Requests\OfficeUpdateRequest;
use App\Models\Office;
use App\Models\Schedule;

class OfficeController extends Controller
{
    public function index(OfficeIndexRequest $request)
    {
        $params = $request->validated();
        $stateId = isset($params['state_id']) ? $params['state_id'] : null;
        $countryId = isset($params['country_id']) ? $params['country_id'] : null;

        $offices = Office::join('states', 'states.id', 'offices.state_id')
            ->when(!is_null($stateId), function ($query) use ($stateId) {
                $query->where('state_id', $stateId);
            })
            ->when(!is_null($countryId), function ($query) use ($countryId) {
                $query->where('country_id', $countryId);
            })
            ->paginate($request->per_page);

        return response()->json($offices);
    }

    public function store(OfficeStoreRequest $request)
    {
        $office = $request->validated();
        Office::create($office);
        return response()->noContent();
    }

    public function show(int $id)
    {
        $state = Office::join('states', 'states.id', 'offices.state_id')
            ->where('offices.id', $id)
            ->first();
        return is_null($state) ? abort(404, 'Not Found') : response()->json($state);
    }

    public function update(OfficeUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $office = Office::find($id);

        if (is_null($office)) {
            return abort(404, 'Not Found');
        }
        foreach ($data as $key => $value) {
            $office[$key] = $value;
        }

        $office->save();
        return response()->noContent();
    }

    public function destroy(int $id)
    {
        if (Schedule::first('course_id', $id)) {
            return abort(400, 'Data is being used');
        }
        $isDeleted = Office::destroy($id);
        return $isDeleted ? response()->noContent() : abort(404, 'Not Found');
    }
}
