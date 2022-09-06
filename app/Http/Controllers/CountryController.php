<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryStoreRequest;
use App\Http\Requests\CountryUpdateRequest;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return response()->json($countries);
    }

    public function store(CountryStoreRequest $request)
    {
        $country = $request->validated();
        Country::create($country);
        return response()->noContent();
    }

    public function show(int $id)
    {
        $country = Country::find($id);
        return is_null($country) ? abort(404, 'Not Found') : response()->json($country);
    }

    public function update(CountryUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $country = Country::find($id);

        if (is_null($country)) {
            return abort(404, 'Not Found');
        }
        foreach ($data as $key => $value) {
            $country[$key] = $value;
        }

        $country->save();
        return response()->noContent();
    }

    public function destroy($id)
    {
        $isDeleted = Country::destroy($id);
        return $isDeleted ? response()->noContent() : abort(404, 'Not Found');
    }
}
