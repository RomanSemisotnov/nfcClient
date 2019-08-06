<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'uri'];

    public function params()
    {
        return $this->hasMany(QueryParam::class);
    }


}
