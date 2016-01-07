<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Memcached;
use Laravel\Lumen\Routing\Controller as BaseController;

class BackendController extends BaseController
{
    public function postGenerate(Request $request) {
        try {
            $this->validate($request, [
                'title' => 'required|unique:posts|max:255',
                'body' => 'required',
            ]);
        } catch(HttpResponseException $e) {
            die('Error');
        }
    }

    public function postDestroy() {
        $this->validate($request, [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);
    }
}
