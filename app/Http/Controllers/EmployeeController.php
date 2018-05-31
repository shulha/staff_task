<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Feature;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $employees = Employee::all();

        $arrayMean = Employee::mean();
        $mean = array_shift($arrayMean)->mean;

        foreach ($employees as $employee) {
            $emp[$employee->id]['image'] = $employee->image;
            $emp[$employee->id]['surname'] = $employee->surname;
            $emp[$employee->id]['name'] = $employee->name;
            $emp[$employee->id]['patronymic'] = $employee->patronymic;
            $emp[$employee->id]['projects'] = $employee->projects;
            foreach ($employee->features as $item) {
                $emp[$employee->id]['features'][$item->title] = $item->pivot->weight;
            }
        }

        return ['employees'=>$emp, 'mean'=>$mean];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $features = Feature::pluck('title', 'id');
        $projects = Project::pluck('title', 'id');

        return compact('features', 'projects');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Employee
     */
    public function store(Request $request)
    {
        $input = json_decode($request->input('employee'), true);

        $rules = [
            "name" => "required",
            "patronymic" => "required",
            "surname" => "required",
            "weight.*" => "numeric|between:0,10",
            "selected.*" => "required",
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 400);
        }

        $featureList = $input['weight'];
        $projectList = $input['selected'];

        $timeManagerId = Feature::where('title', '=', 'Тайм менеджмент')->value('id');
        $timeManagerIdWeight = (int)$featureList[$timeManagerId];

        if ($timeManagerIdWeight != 10 and count($projectList) > 1) {
            return Response::json(array(
                'success' => false,
                'errors' => "«Тайм менеджмент» со значением ниже 10 не может иметь больше одного проекта"

            ), 400);
        }

        $imageName = 'avatar.png';
        $image = Input::file('image');
        if ($image) {
            $validator = Validator::make(
                ["image" => $image],
                ["image" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048"]);
            if ($validator->fails()) {
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 400);
            }
            $imageName = time() . str_random(3) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $imageName);
        }

        /** @var Employee $employee */
        $employee = Employee::create(array_merge($input, ['image' => $imageName]));

        $employee->projects()->sync($projectList);

        foreach ($featureList as $featureId => $weight) {
            $weightList[$featureId] = ['weight' => $weight];
        }
        $employee->features()->sync($weightList);

        return $employee;
    }

    public function searchEmployee(Request $request)
    {
        if ($request->isMethod('post')){

            $searchString = $request->input('searchString');
            if(empty($searchString))
                return response()->json(['success' => false], 400);

            $employees = Employee::search($searchString);

            foreach ($employees as $employee) {
                $emp[$employee->id]['image'] = $employee->image;
                $emp[$employee->id]['surname'] = $employee->surname;
                $emp[$employee->id]['name'] = $employee->name;
                $emp[$employee->id]['patronymic'] = $employee->patronymic;
                $emp[$employee->id]['features'][$employee->feature_title] = $employee->weight;
                $emp[$employee->id]['projects'][$employee->project_title] = $employee->project_title;
            }
            return ['employees'=>$emp];
        }

        return response()->json(['success' => false], 405);
    }
}
