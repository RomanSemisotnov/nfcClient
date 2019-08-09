<?php

namespace App\Http\Controllers;

use App\CorrectRequest;
use App\CorrectRequestParam;
use App\IncorrentRequest;
use App\Servicec\ClientService;
use Illuminate\Http\Request;

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

        try{
            $client_params = $client->params;

            for ($i = 0, $url_params_index = 1; $i < count($client_params); $i++, $url_params_index++) {
                $current_variables = $client_params[$i]->variables->pluck('name')->toArray();
                if (!in_array($url_params[$url_params_index], $current_variables)) {
                    IncorrentRequest::create([
                        'uri' => $request->url(),
                        'client_id' => $client->id,
                        'ip' => $request->ip()
                    ]);
                    return redirect($client->uri);
                }
            }

            $request = CorrectRequest::create([
                'client_id' => $client->id,
                'ip' => $request->ip()
            ]);

            for ($i = 0, $url_params_index = 1; $i < count($client_params); $i++, $url_params_index++) {
                foreach ($client_params[$i]->variables as $variable) {
                    if ($variable->name === $url_params[$url_params_index]) {
                        CorrectRequestParam::create([
                            'correctrequest_id' => $request->id,
                            'queryparam_id' => $client_params[$i]->id,
                            'paramvariable_id' => $variable->id
                        ]);
                    }
                }
            }
        }catch (\Exception $e){
            IncorrentRequest::create([
                'uri' => $request->url(),
                'client_id' => $client->id,
                'ip' => $request->ip()
            ]);
        }

        return redirect($client->uri);
    }


}
