<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'patronymic',
        'surname',
        'image'
    ];

    public function features()
    {
        return $this->belongsToMany('App\Feature')->withPivot('weight');
    }

    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }

    /**
     * The average value of the features of all employees
     *
     * @return mixed
     */
    public static function mean()
    {
        return DB::select('SELECT avg(average) as mean 
                           FROM (SELECT avg(weight) as average 
                                 FROM employee_feature 
                                 GROUP BY employee_id) as new_table');
    }

    /**
     * Search by name or patronymic or surname of Employee
     *
     * @param $var
     * @return mixed
     */
    public static function search($var)
    {
        return DB::table('employees')
            ->join('employee_project', 'employees.id', '=', 'employee_project.employee_id')
            ->join('projects', 'employee_project.project_id', '=', 'projects.id')
            ->join('employee_feature', 'employees.id', '=', 'employee_feature.employee_id')
            ->join('features', 'employee_feature.feature_id', '=', 'features.id')
            ->select('employees.id', 'name', 'patronymic', 'surname', 'image', 'features.title AS feature_title', 'weight', 'projects.title AS project_title')
            ->where('name', 'LIKE', '%' . $var . '%')
            ->orWhere('patronymic', 'LIKE', '%' . $var . '%')
            ->orWhere('surname', 'LIKE', '%' . $var . '%')
            ->get();
    }
}
