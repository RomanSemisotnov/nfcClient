<?php

namespace App\Http\Controllers;

use App\ParamVariable;
use App\QueryParam;
use Illuminate\Http\Request;

class QueryParamsController extends Controller
{


    public function update(Request $request, int $id)
    {
        $newName = $request->input('name');
        if(!$newName){
            $newName='';
        }
        $type = $request->input('type');
        QueryParam::findOrFail($id)->update(['name' => $newName, 'type' => $type]);
        return 'success';
    }


    public function delete(Request $request, int $id)
    {
        $current = QueryParam::findOrFail($id);
        $current_number = $current->index_number;
        $client_id = $current->client_id;

        $last = QueryParam::whereClient_id($client_id)->orderBy('index_number', 'desc')->first();
        $last_id = $last->index_number;

        $current->delete();

        for ($i = $current_number + 1; $i <= $last_id; $i++) {
            QueryParam::where(['client_id' => $client_id, 'index_number' => $i])
                ->update(['index_number' => $i - 1]);
        }

        return 'success';
    }
}
