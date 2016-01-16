<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Memcached;
use DB;
use Laravel\Lumen\Routing\Controller as BaseController;

use GuzzleHttp;

class BackendController extends BaseController
{
    public function postGenerate(Request $request) {
        $this->validate($request, [
            'fqdn' => 'required|string|max:16|unique:records',
            'ip' => 'required|ip|unique:records',
        ]);

        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.cloudflare.com']);

        $key = json_decode($client->request('GET', '/client/v4/zones?name='.env('CLOUDFLARE_DOMAIN').'&status=active&page=1&per_page=1', [
            'headers' => [
                'X-Auth-Email' => env('CLOUDFLARE_EMAIL'),
                'X-Auth-Key' => env('CLOUDFLARE_KEY')
            ]
        ])->getBody()->getContents())->result['0']->id;

        $record = json_decode($client->request('POST', '/client/v4/zones/'.$key.'/dns_records', [
            'headers' => [
                'X-Auth-Email' => env('CLOUDFLARE_EMAIL'),
                'X-Auth-Key' => env('CLOUDFLARE_KEY')
            ],
            'json' => [
                'type' => 'A',
                'name' => $request->input('fqdn').config('cloudflare.domain'),
                'content' => $request->input('ip')
            ]
        ])->getBody()->getContents())->result->id;

        DB::table('records')->insert(['token' => $record, 'fqdn' => $request->input('fqdn'), 'ip' => $request->input('ip')]);

        return redirect()->route('index')->with('key', $record);
    }

    public function postDestroy(Request $request) {
        $this->validate($request, [
            'token' => 'required|exists:records'
        ]);

        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.cloudflare.com']);

        $key = json_decode($client->request('GET', '/client/v4/zones?name='.env('CLOUDFLARE_DOMAIN').'&status=active&page=1&per_page=1', [
            'headers' => [
                'X-Auth-Email' => env('CLOUDFLARE_EMAIL'),
                'X-Auth-Key' => env('CLOUDFLARE_KEY')
            ]
        ])->getBody()->getContents())->result['0']->id;

        $response = $client->request('DELETE', '/client/v4/zones/'.$key.'/dns_records/'.$request->input('token'), [
            'headers' => [
                'X-Auth-Email' => env('CLOUDFLARE_EMAIL'),
                'X-Auth-Key' => env('CLOUDFLARE_KEY')
            ]
        ]);

        DB::table('records')->where(['token' => $request->input('token')])->delete();

        return redirect()->route('index')->with('delete', 1);
    }
}
