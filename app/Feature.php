<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'title',
        'weight'
    ];

    public function employees()
    {
        return $this->belongsToMany('App\Employee');
    }
}
