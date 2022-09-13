<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleIndexRequest;
use App\Http\Requests\ScheduleStoreRequest;
use App\Http\Requests\ScheduleUpdateRequest;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index(ScheduleIndexRequest $request)
    {
        $params = $request->validated();
        $dateStart = $params['date_start'];
        $dateEnd = $params['date_end'];
        $courseId = isset($params['course_id']) ? $params['course_id'] : null;
        $officeId = isset($params['office_id']) ? $params['office_id'] : null;
        $stateId = isset($params['state_id']) ? $params['state_id'] : null;
        $countryId = isset($params['country_id']) ? $params['country_id'] : null;

        $schedule = Schedule::join('courses', 'courses.id', 'schedules.course_id')
            ->join('offices', 'offices.id', 'schedules.office_id')
            ->join('states', function ($join) use ($stateId) {
                $join->on('states.id', 'offices.state_id')
                    ->when($stateId, function ($query) use ($stateId) {
                        $query->where('states.id', $stateId);
                    });
            })
            ->join('countries', function ($join) use ($countryId) {
                $join->on('countries.id', 'states.country_id')
                    ->when($countryId, function ($query) use ($countryId) {
                        $query->where('countries.id', $countryId);
                    });
            })
            ->when($officeId, function ($query) use ($officeId) {
                $query->where('schedules.office_id', $officeId);
            })
            ->when($courseId, function ($query) use ($courseId) {
                $query->where('schedules.course_id', $courseId);
            })
            ->whereBetween('date_start', [$dateStart, $dateEnd])
            ->OrWhereBetween('date_end', [$dateStart, $dateEnd])
            ->select([
                'schedules.id',
                'courses.name as course_name',
                'offices.name as office_name',
                'states.name as state_name',
                'countries.name as country_name',
                'schedules.img_ref',
                'schedules.date_start',
                'schedules.date_end',
                'schedules.created_at',
                'schedules.updated_at',
            ])
            ->paginate($request->per_page);

        return response()->json($schedule);
    }

    public function store(ScheduleStoreRequest $request)
    {
        $schedule = $request->validated();
        Schedule::create($schedule);
        return response()->noContent();
    }

    public function show(int $id)
    {
        $schedule = Schedule::join('courses', 'courses.id', 'schedules.course_id')
            ->join('offices', 'offices.id', 'schedules.office_id')
            ->join('states', 'states.id', 'offices.state_id')
            ->join('countries', 'countries.id', 'states.country_id')
            ->where('schedules.id', $id)
            ->first([
                'schedules.id',
                'courses.name as course_name',
                'offices.name as office_name',
                'states.name as state_name',
                'countries.name as country_name',
                'schedules.img_ref',
                'schedules.date_start',
                'schedules.date_end',
                'schedules.created_at',
                'schedules.updated_at',
            ]);

        return is_null($schedule) ? abort(404, 'Not Found') : response()->json($schedule);
    }

    public function update(ScheduleUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $schedule = Schedule::find($id);

        if (is_null($schedule)) {
            return abort(404, 'Not Found');
        }
        foreach ($data as $key => $value) {
            $schedule[$key] = $value;
        }

        $schedule->save();
        return response()->noContent();
    }

    public function destroy(int $id)
    {
        $isDeleted = Schedule::destroy($id);
        return $isDeleted ? response()->noContent() : abort(404, 'Not Found');
    }
}
