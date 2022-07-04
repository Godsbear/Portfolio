<?php
namespace App\Utils;

use GuzzleHttp\Client;

class MyRequest
{
    protected $client;
    protected $accessToken;

    public function __construct($accessToken = null)
    {
        $this->client = new Client([
            'base_uri' => 'https://fb-dev-gateway.herokuapp.com/',
            'timeout' => 30,
        ]);
        $this->accessToken = $accessToken;
    }

    public function request($method, $path, $queryParams = [], $bodyParams = [])
    {
        // Encode query parameters
        array_walk($queryParams, function ($value, $key) use (&$queryParams) {
            $queryParams[$key] = urlencode($key).'='.urlencode($value);
        });
        $queryParams = implode('&', $queryParams);

        $headers = ($this->accessToken) ? [ 'Authorization' => 'Bearer ' . $this->accessToken ] : [];

        $response = $this->client->request($method, $path.'?'.$queryParams, [
            'json' => $bodyParams,
            'headers' => $headers,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}