<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatternLink extends Model
{


    protected $fillable = ['value', 'withToken', 'redirectTo', 'client_id'];


    public function uids()
    {
        return $this->hasMany(Uid::class);
    }

}
