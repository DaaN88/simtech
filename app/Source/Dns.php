<?php

namespace App\Source;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Dns
{
    /**
     * @var \GuzzleHttp\Client
    */
    protected $client;

    /**
     * @see EntryPoint::dns()
    */
    protected $request;

    /**
     * Construct
     *
     * @param \GuzzleHttp\Client $client
     * @param string $request
     */
    public function __construct(Client $client, string $request)
    {
        $this->client = $client;
        $this->request = $request;
    }

    /**
     * Method makes a request by url and returns the response
    */
    public function get(): string
    {
        try {
            $dns = $this->client->get($this->request);
        } catch (GuzzleException $msg) {
            return $msg->getResponse()->getBody()->getContents();
        }

        return $dns->getBody()->getContents();
    }
}
