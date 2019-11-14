<?php

namespace App\Http\Controllers;

use App\CorrectRequest;
use App\Device;
use App\Exceptions\InvalidDeviceException;
use App\Exceptions\InvalidRequestException;
use App\IncorrentRequest;
use App\PatternLink;
use App\Servicec\ClientService;
use App\Servicec\DeviceService;
use App\Uid;
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

            $fullRequest = explode('/', $request->url());
            $uidValue = array_pop($fullRequest);
            $urlWithOutUid = implode('/', $fullRequest) . '/';

            $link = PatternLink::whereValue($urlWithOutUid)->whereHas('uids', function ($query) use ($uidValue) {
                $query->whereValue($uidValue);
            })->with('uids')->first();

            if ($link === null)
                throw new InvalidRequestException('Link not found');

            $url_withOut_protocol = preg_replace('@^http(s)?://@i', '', $request->url());
            $url_params = explode('/', $url_withOut_protocol);
            array_shift($url_params);
            array_pop($url_params);

            $uidIndexInCollection = array_search(trim($uidValue), $link->uids->pluck('value')->toArray());

            $correct_request = CorrectRequest::create([
                'client_id' => $client->id,
                'device_id' => $device->id,
                'ip' => $request->ip(),
                'uid_id' => $link->uids->get($uidIndexInCollection)->id
            ]);

            $variable_ids = [];
            $client_params = $client->params;
            $client_params_count = count($client_params);
            for ($i = 0; $i < $client_params_count; $i++) {
                foreach ($client_params[$i]->variables as $variable) {
                    if ($variable->name === $url_params[$i]) {
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
            return 'is not a telephone or table';
        } catch (InvalidRequestException $e) {
            IncorrentRequest::create([
                'uri' => $request->url(),
                'client_id' => $client->id,
                'device_id' => $device->id,
                'ip' => $request->ip()
            ]);
            return '404 not found';
        } catch (\Exception $e) {
            return "Обратитесь к Роману <br>" . $e->getMessage() . " " . $e->getLine();
        }
    }

}
