<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{


    protected $fillable = [
        'patternlink_id', 'needLinks', 'isActive', 'client_id'
    ];


    public function uids()
    {
        return $this->hasMany(Uid::class, 'record_id');
    }

    public function patternlink()
    {
        return $this->belongsTo(PatternLink::class, 'patternlink_id');
    }



}
