<?php

namespace App\Http\Controllers;

use App\ParamVariable;
use Illuminate\Http\Request;

class VariableParamController extends Controller
{


    public function create(Request $request){
        $name=$request->input('name');
        $param_id=$request->input('param_id');

        return ParamVariable::create([
            'name' => $name,
            'QueryParam_id' => $param_id
        ]);
    }

    public function delete(Request $request, int $id){
        ParamVariable::findOrFail($id)->delete();
        return 'success';
    }



}
