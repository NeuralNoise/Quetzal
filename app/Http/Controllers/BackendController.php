<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Memcached;
use DB;
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
        $flare->delete($request->input('token'));

        return redirect()->route('index')->with('delete', 1);
    }
}
