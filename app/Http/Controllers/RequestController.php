<?php

namespace App\Http\Controllers;

use App\CorrectRequest;
use App\Device;
use App\Exceptions\InvalidDeviceException;
use App\IncorrentRequest;
use App\PatternLink;
use App\Servicec\ClientService;
use App\Servicec\DeviceService;
use Illuminate\Http\Request;

class RequestController extends Controller
{

    protected $clientService;
    protected $deviceService;

    public function __construct(ClientService $clientService, DeviceService $deviceService)
    {
        $this->clientService = $clientService;
        $this->deviceService = $deviceService;
    }

    public function __invoke(Request $request)
    {
        return $_SERVER['HTTP_USER_AGENT'];
        try {
            $client = $this->clientService->get();

            if ($this->deviceService->isComputer())
                throw new InvalidDeviceException();

            if ($this->deviceService->isMobile()) {
                $deviceName = $this->deviceService->getMobile();
            } elseif ($this->deviceService->isTablet()) {
                $deviceName = $this->deviceService->getTablet();
            } else {
                $deviceName = 'unknown';
            }
            $device = Device::firstOrCreate(['name' => $deviceName]);

            $link = PatternLink::whereValue($request->url())->first();
            if ($link === null)
                throw new \Exception('link not found');

            $url_withOut_protocol = preg_replace('@^http(s)?://@i', '', $request->url());
            $url_params = explode('/', $url_withOut_protocol);

            $client_params = $client->params;

            $correct_request = CorrectRequest::create([
                'client_id' => $client->id,
                'device_id' => $device->id,
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
        } catch (InvalidDeviceException $e) {
            $device = Device::firstOrCreate(['name' => 'computer']);
            IncorrentRequest::create([
                'uri' => $request->url(),
                'client_id' => $client->id,
                'device_id' => $device->id,
                'ip' => $request->ip()
            ]);
            return 'is computer';
        } catch (\Exception $e) {
            IncorrentRequest::create([
                'uri' => $request->url(),
                'client_id' => $client->id,
                'device_id' => $device->id,
                'ip' => $request->ip()
            ]);
            return '404 not found';
        }
    }

}
