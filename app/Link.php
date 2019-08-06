<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['uri', 'uid_id', 'client_id'];


    public function uid()
    {
        return $this->belongsTo(Uid::class);
    }

}
