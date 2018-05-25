<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Feature;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();

        $arrayMean = Employee::mean();
        $mean = array_shift($arrayMean)->mean;

        return view('index', compact('employees', 'mean'));
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

        return view('create', compact('features', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "patronymic" => "required",
            "surname" => "required",
            "feature_list.*" => "numeric|between:0,10",
            "project_list.*" => "required",
            "image" => "bail|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        $featureList = $request->input('feature_list');
        $projectList = $request->input('project_list');

        $timeManagerId = Feature::where('title', '=', 'Тайм менеджмент')->value('id');
        $timeManagerIdWeight = (int)$featureList[$timeManagerId];

        if ($timeManagerIdWeight != 10 and count($projectList) > 1) {
            return redirect()->route('create_employee')
                ->withErrors("«Тайм менеджмент» со значением ниже 10 не может иметь больше одного проекта")
                ->withInput($request->input());
        }

        $imageName = null;
        if ($image = $request->file('image'))
        {
            $imageName = time() . str_random(3) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $imageName);
        }

        /** @var Employee $employee */
        $employee = Employee::create(array_merge($request->all(), ['image' => $imageName]));

        $employee->projects()->sync($projectList);

        foreach ($featureList as $featureId => $weight) {
            $weightList[$featureId] = ['weight' => $weight];
        }
        $employee->features()->sync($weightList);

        session()->flash('flash_message', 'Your employee has been created!');
        session()->flash('flash_message_important', true);

        return redirect()->route('home');
    }

}
