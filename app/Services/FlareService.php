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
    public function zone()
    {
        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.cloudflare.com']);

        $zone = json_decode($client->request('GET', '/client/v4/zones?name='.env('CLOUDFLARE_DOMAIN').'&status=active&page=1&per_page=1', [
            'headers' => [
                'X-Auth-Email' => env('CLOUDFLARE_EMAIL'),
                'X-Auth-Key' => env('CLOUDFLARE_KEY')
            ]
        ])->getBody()->getContents())->result['0']->id;

        return $zone;
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
    public function create($fqdn, $ip)
    {
        $zone = $this->zone();

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
        $zone = $this->zone();

        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.cloudflare.com']);

        $client->request('DELETE', '/client/v4/zones/'.$zone.'/dns_records/'.$token, [
            'headers' => [
                'X-Auth-Email' => env('CLOUDFLARE_EMAIL'),
                'X-Auth-Key' => env('CLOUDFLARE_KEY')
            ]
        ]);
    }
}