<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatternLink extends Model
{


    protected $fillable = ['value', 'redirectTo', 'client_id'];


    public function records()
    {
        return $this->hasMany(Record::class, 'patternlink_id');
    }

    public function uids()
    {
        return $this->hasMany(Uid::class, 'patternlink_id');
    }

}
