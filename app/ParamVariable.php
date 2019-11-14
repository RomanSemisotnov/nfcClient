<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParamVariable extends Model
{


    protected $table = 'param_variables';

    protected $fillable = ['name', 'QueryParam_id'];

    public function param()
    {
        return $this->belongsTo(QueryParam::class);
    }

    public function requests()
    {
        return $this->belongsToMany(CorrectRequest::class, 'request_variable',
            'paramvariable_id', 'correctrequest_id');
    }

}
