<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses);
    }

    public function store(CourseStoreRequest $request)
    {
        $course = $request->validated();
        Course::create($course);
        return response()->noContent();
    }

    public function show(int $id)
    {
        $course = Course::find($id);
        return is_null($course) ? abort(404, 'Not Found') : response()->json($course);
    }

    public function update(CourseUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $course = Course::find($id);

        if (is_null($course)) {
            return abort(404, 'Not Found');
        }
        foreach ($data as $key => $value) {
            $course[$key] = $value;
        }

        $course->save();
        return response()->noContent();
    }

    public function destroy($id)
    {
        $isDeleted = Course::destroy($id);
        return $isDeleted ? response()->noContent() : abort(404, 'Not Found');
    }
}
