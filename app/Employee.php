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
            ->where('name', 'LIKE', '%' . $var . '%')
            ->orWhere('patronymic', 'LIKE', '%' . $var . '%')
            ->orWhere('surname', 'LIKE', '%' . $var . '%')
            ->get();
    }
}
