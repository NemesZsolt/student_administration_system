<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'gender_id',
        'place_of_birth',
        'date_of_birth',
        'email_address'
    ];

    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }

    public function enrolled()
    {
        return $this->hasMany('App\EnrolledStudent')->with('group');
    }
}
