<?php

namespace App\Http\Controllers;

use App\Client;
use App\QueryParam;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index()
    {
        return Client::all();
    }

    public function get(string $name)
    {
        $client = Client::whereName($name)->with('params.variables')->first();
        return $client;
    }

    public function store(Request $request)
    {
        $client = Client::create([
            'name' => $request->input('name'),
            'uri' => $request->input('redirectTo')
        ]);
        for ($i = 1; $i <= 5; $i++) {
            QueryParam::create([
                'client_id' => $client->id,
                'name' => '',
                'index_number' => $i
            ]);
        }
        return $client;
    }


}
