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

    public function getName()
    {
        return 'dodo';
        //return preg_replace('@^http(s)?://@i', '', $this->request->root());
    }

    public function getClientByName()
    {
        try {
            return Client::whereName($this->getName())->with('params.variables')->first();
        } catch (\Exception $e) {
            abort(404, 'Client not found');
        }
    }

}