<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'uri', 'subdomain'];

    public function params()
    {
        return $this->hasMany(QueryParam::class)->orderBy('index_number');
    }


}