<?php
namespace App\Services;

use DB;
use GuzzleHttp;

class FlareService
{
    /**
     * Get the zone identifier of a domain in cloudflare.
     *
     * @return string
     */
    public function zone($fqdn = 'all')
    {
        if($fqdn != 'all') {
            $client = new GuzzleHttp\Client(['base_uri' => 'https://api.cloudflare.com']);

            $zone = json_decode($client->request('GET', '/client/v4/zones?name='.$fqdn.'&status=active&page=1&per_page=1', [
                'headers' => [
                    'X-Auth-Email' => env('CLOUDFLARE_EMAIL'),
                    'X-Auth-Key' => env('CLOUDFLARE_KEY')
                ]
            ])->getBody()->getContents())->result['0']->id;

            return $zone;
        } else {
            $client = new GuzzleHttp\Client(['base_uri' => 'https://api.cloudflare.com']);

            $zones = json_decode($client->request('GET', '/client/v4/zones?status=active', [
                'headers' => [
                    'X-Auth-Email' => env('CLOUDFLARE_EMAIL'),
                    'X-Auth-Key' => env('CLOUDFLARE_KEY')
                ]
            ])->getBody()->getContents())->result;

            return $zones;
        }
    }

    /**
     * Check if a similar record already exists.
     *
     * @param string $fqdn
     * @param string $ip
     * @return string
     */
    public function available($zone, $fqdn, $ip)
    {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.cloudflare.com']);

        $exists = json_decode($client->request('GET', '/client/v4/zones/'.$zone.'/dns_records?name='.$fqdn.'&content='.$ip.'&match=any', [
            'headers' => [
                'X-Auth-Email' => env('CLOUDFLARE_EMAIL'),
                'X-Auth-Key' => env('CLOUDFLARE_KEY')
            ]
        ])->getBody()->getContents())->result;

        if($exists) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Create a Cloudflare record and store it in the database.
     *
     * @param string $fqdn
     * @param string $ip
     * @return string
     */
    public function create($domain, $fqdn, $ip)
    {
        $zone = $this->zone($domain);

        if($this->available($zone, $fqdn, $ip)) {
            $client = new GuzzleHttp\Client(['base_uri' => 'https://api.cloudflare.com']);

            $record = json_decode($client->request('POST', '/client/v4/zones/'.$zone.'/dns_records', [
                'headers' => [
                    'X-Auth-Email' => env('CLOUDFLARE_EMAIL'),
                    'X-Auth-Key' => env('CLOUDFLARE_KEY')
                ],
                'json' => [
                    'type' => 'A',
                    'name' => $fqdn,
                    'content' => $ip
                ]
            ])->getBody()->getContents())->result->id;

            return $record;
        } else {
            return false;
        }
    }

    /**
     * Destroy a record and remove it from the database.
     *
     * @param string $fqdn
     * @param string $ip
     * @return void
     */
    public function destroy($token)
    {
        $zones = $this->zone();
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.cloudflare.com', ]);

        foreach($zones as $zone) {
            $client->request('DELETE', '/client/v4/zones/'.$zone->id.'/dns_records/'.$token, [
                'http_errors' => false,
                'headers' => [
                    'X-Auth-Email' => env('CLOUDFLARE_EMAIL'),
                    'X-Auth-Key' => env('CLOUDFLARE_KEY')
                ]
            ]);
        }
    }
}