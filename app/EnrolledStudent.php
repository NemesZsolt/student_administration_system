<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnrolledStudent extends Model
{
    protected $fillable = [
        'student_id',
        'study_group_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('App\StudyGroup', 'study_group_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function studyGroup()
    {
        return $this->belongsTo('App\StudyGroup');
    }
}
