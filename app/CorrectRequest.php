<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorrectRequest extends Model
{

    protected $fillable = ['uid_id', 'isConversion', 'client_id', 'device_id', 'ip'];

    public function variables()
    {
        return $this->belongsToMany(ParamVariable::class, 'request_variable',
            'correctrequest_id', 'paramvariable_id');
    }

    public function addVariable(array $variable_ids)
    {
        return $this->variables()->attach($variable_ids);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

}
