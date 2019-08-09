<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncorrentRequest extends Model
{

    protected $fillable = ['uri', 'client_id', 'device_id', 'ip'];

}
