<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class FrontendController extends BaseController
{
    public function getIndex()
    {
        return view('index', ['domains' => explode(', ', env('CLOUDFLARE_DOMAIN'))]);
    }
}
