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

}
