<?php

namespace App\Servicec;

use App\Client;
use Illuminate\Http\Request;

class ClientService
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getSubDomainName()
    {
        return explode('.', preg_replace('@^http(s)?://@i', '', $this->request->root()))[0];
    }

    public function get()
    {
       // return Client::whereSubdomain('mozaiqa')->with('params.variables')->first();
        return Client::whereSubdomain($this->getSubDomainName())->with('params.variables')->first();
    }

}
