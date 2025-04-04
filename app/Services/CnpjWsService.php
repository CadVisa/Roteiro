<?php

namespace App\Services;

use GuzzleHttp\Client;

class CnpjWsService
{

    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://publica.cnpj.ws/cnpj/';
    }

    public function consultarCNPJ($cnpj)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . $cnpj);

        return json_decode($response->getBody(), true);
    }
}
