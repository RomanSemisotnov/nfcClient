<?php

namespace App\Http\Controllers;

use App\CorrectRequest;
use App\IncorrentRequest;
use App\PatternLink;
use App\Servicec\ClientService;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class RequestController extends Controller
{

    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function __invoke(Request $request)
    {
        $url_withOut_protocol = preg_replace('@^http(s)?://@i', '', $request->url());
        $url_params = explode('/', $url_withOut_protocol);

        $client = $this->clientService->getClientBySubDomain();

        try {
            $link = PatternLink::whereClient_idAndValue($client->id, $request->url())->first();
            if ($link === null)
                throw new \Exception('link not found');

            $client_params = $client->params;

            for ($i = 0, $url_params_index = 1; $i < count($client_params); $i++, $url_params_index++) {
                $current_variables = $client_params[$i]->variables->pluck('name')->toArray();
                if (!in_array($url_params[$url_params_index], $current_variables)) {
                    IncorrentRequest::create([
                        'uri' => $request->url(),
                        'client_id' => $client->id,
                        'ip' => $request->ip()
                    ]);
                    return redirect($link->redirectTo);
                }
            }

            $correct_request = CorrectRequest::create([
                'client_id' => $client->id,
                'ip' => $request->ip()
            ]);
            $variable_ids = [];
            for ($i = 0, $url_params_index = 1; $i < count($client_params); $i++, $url_params_index++) {
                foreach ($client_params[$i]->variables as $variable) {
                    if ($variable->name === $url_params[$url_params_index]) {
                        $variable_ids[] = $variable->id;
                    }
                }
            }
            $correct_request->addVariable($variable_ids);

            return redirect($link->redirectTo);
        } catch (\Exception $e) {
            IncorrentRequest::create([
                'uri' => $request->url(),
                'client_id' => $client->id,
                'ip' => $request->ip()
            ]);
            return '404 not found';
        }
    }


}
