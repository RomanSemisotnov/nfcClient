<?php

namespace App\Http\Controllers;

use App\Client;
use App\Link;
use App\Uid;
use Illuminate\Http\Request;

class LinksController extends Controller
{

    public function get(Request $request, int $client_id)
    {
        $links = Link::whereClient_id($client_id);

        if ($request->input('uid') === 'without') {
            $links->whereDoesntHave('uid');
        } else if ($request->input('uid') === 'with') {
            $links->whereHas('uid');
        }

        return $links->orderBy('id', 'desc')->paginate(20);
    }

    public function store(Request $request)
    {
        if (!in_array('token', $request->input('params'))) {
            abort(400, 'token not found');
        }
        if ($request->input('count') === null)
            abort(400, 'Count links is null');

        $client = Client::whereId($request->input('client_id'))->with('params.variables')->first();
        $params = $request->input('params');


        for ($i = 0; $i < count($params); $i++) {
            if ($params[$i] !== 'token' && !in_array($params[$i], $client->params[$i]->variables->pluck('name')->toArray())) {
                abort(400, "Parament " . ($i + 1) . " incorrect");
            }
        }


        for ($i = 0; $i < $request->input('count'); $i++) {
            $domain = "https://" . $client->name . ".nfc-u.ru/";
            foreach ($params as $param) {
                if ($param !== 'token') {
                    $domain .= $param . '/';
                }
            }
            Link::create([
                'uri' => $domain,
                'client_id' => $client->id
            ]);
        }


        return 'success';

    }

}
