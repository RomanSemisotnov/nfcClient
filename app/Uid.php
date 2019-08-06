<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uid extends Model
{

    protected $fillable = [
        'value'
    ];

    public function link()
    {
        return $this->hasOne(Link::class);
    }


}
