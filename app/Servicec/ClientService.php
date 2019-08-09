<?php
/**
 * Created by PhpStorm.
 * User: russian_rave
 * Date: 7/31/2019
 * Time: 9:56 AM
 */

namespace App\Servicec;


use App\Client;
use Illuminate\Http\Request;

class ClientService
{

    protected $request;
    public function __construct(Request $request)
    {
        $this->request=$request;
    }

    public function getSubDomainName()
    {
        return explode('.', preg_replace('@^http(s)?://@i', '', $this->request->root()))[0];
    }

    public function getClientBySubDomain()
    {
        return Client::whereSubdomain($this->getSubDomainName())->with('params.variables')->first();
    }

}