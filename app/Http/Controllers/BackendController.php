<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Memcached;
use DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class BackendController extends BaseController
{
    public function postGenerate(Request $request) {
        $this->validate($request, [
            'fqdn' => 'required|string|max:16',
            'ip' => 'required',
        ]);

        DB::table('records')->insert(['token' => str_random(32), 'fqdn' => $request->input('fqdn'), 'ip' => $request->input('ip')]);
    }

    public function postDestroy(Request $request) {
        $this->validate($request, [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);
    }
}
