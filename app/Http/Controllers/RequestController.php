<?php

namespace App\Http\Controllers;

use App\Servicec\ClientService;
use Illuminate\Http\Request;

class RequestController extends Controller
{

    protected $clientService;
    public function __construct(ClientService $clientService)
    {
        $this->clientService=$clientService;
    }

    public function __invoke(Request $request)
    {
        return $this->clientService->getName($request);
    }




}
