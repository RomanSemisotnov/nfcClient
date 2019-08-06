<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueryParam extends Model
{
    protected $table = 'query_params';

    protected $fillable = ['name', 'client_id', 'type', 'index_number'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function variables()
    {
        return $this->hasMany(ParamVariable::class, 'QueryParam_id', 'id');
    }

}
