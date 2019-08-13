<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uid extends Model
{

    protected $fillable = [
        'value', 'patternlink_id'
    ];

    public function patternlink()
    {
        return $this->belongsTo(PatternLink::class);
    }


}
