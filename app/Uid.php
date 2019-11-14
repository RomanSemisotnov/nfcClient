<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uid extends Model
{

    protected $fillable = [
        'value', 'record_id', 'patternlink_id'
    ];

    public function record()
    {
        return $this->belongsTo(Record::class);
    }

    public function correctrequests()
    {
        return $this->hasMany(CorrectRequest::class);
    }

    public function patternlink()
    {
        return $this->belongsTo(PatternLink::class, 'patternlink_id');
    }

}
