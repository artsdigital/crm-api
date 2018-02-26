<?php

namespace DigitalArts\Crm\SiteFormIntegration\Models;

use DigitalArts\Crm\SiteFormIntegration\Interfaces\ModelInterface;
use GuzzleHttp\ClientInterface;

abstract class Base implements ModelInterface
{
    protected $client;
    private $where = [];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function where(array $parameters)
    {
        $this->where = $parameters;
        return $this;
    }

    public function first(): array
    {
        $response = $this->client->request('get', static::INDEX_URI, $this->where);
        $contents = json_decode($response->getBody()->getContents(), 1);
        return $contents['data'][0];
    }

    public function create(array $parameters): array
    {
        $response = $this->client->request('post', static::CREATE_URI, $parameters);
        return json_decode($response->getBody()->getContents(), 1);
    }
}