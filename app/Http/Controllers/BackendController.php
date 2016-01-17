<?php

namespace App\Http\Controllers;

use DB;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Http\Memcached;
use Laravel\Lumen\Routing\Controller as BaseController;

use App\Services\FlareService;

class BackendController extends BaseController
{
    public function postGenerate(Request $request) {
        $this->validate($request, [
            'fqdn' => 'required|string|max:16|unique:records',
            'ip' => 'required|ip|unique:records',
        ]);

        $flare = new FlareService;
        $record = $flare->create($request->input('fqdn'), $request->input('ip'));

        return redirect()->route('index')->with('key', $record);
    }

    public function postDestroy(Request $request) {
        $this->validate($request, [
            'token' => 'required|exists:records'
        ]);

        $flare = new FlareService;
        $flare->destroy($request->input('token'));

        return redirect()->route('index')->with('delete', 1);
    }

    public function apiPostGenerate(Request $request) {
        $validator = Validator::make($request->all(), [
            'fqdn' => 'required|string|max:16|unique:records',
            'ip' => 'required|ip|unique:records',
        ]);

        if($validator->fails()) {
            return response()->json(['success' => 0, 'message' => $validator->errors()->all()[0]]);
        }

        $flare = new FlareService;
        $record = $flare->create($request->input('fqdn'), $request->input('ip'));

        return response()->json(['success' => 1, 'message' => 'The record was created successfully.', 'token' => $record]);
    }

    public function apiDeleteDestroy(Request $request) {
        $validator = Validator::make($request->all(), [
            'token' => 'required|exists:records'
        ]);

        if($validator->fails()) {
            return response()->json(['success' => 0, 'message' => $validator->errors()->all()[0]]);
        }

        $flare = new FlareService;
        $flare->destroy($request->input('token'));

        return response()->json(['success' => 1, 'message' => 'The record was deleted successfully.']);
    }
}
