<?php

namespace DigitalArts\Crm\SiteFormIntegration\Models;

use DigitalArts\Crm\SiteFormIntegration\Exceptions\NotSettedProjectId;
use DigitalArts\Crm\SiteFormIntegration\Exceptions\ProjectIdExpectedException;
use DigitalArts\Crm\SiteFormIntegration\Interfaces\ModelInterface;
use GuzzleHttp\ClientInterface;

abstract class Base implements ModelInterface
{
    protected $client;
    private $projectId;
    private $where = [];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function where($parameters)
    {
        $this->where = $parameters;
        return $this;
    }

    public function first()
    {
        if (empty($this->projectId)) {
            throw new ProjectIdExpectedException('Expected set projectId property');
        }
        $response = $this->client->request('get', $this->indexUri(), ['json' => $this->where]);
        $contents = json_decode($response->getBody()->getContents(), 1);
        if (empty($contents['data'][0])) {
            return [];
        }
        return $contents['data'][0];
    }

    public function create($parameters)
    {
        $response = $this->client->request('post', $this->createUri(), ['json' => $parameters]);
        return json_decode($response->getBody()->getContents(), 1);
    }

    public function setProjectId($id)
    {
        $this->projectId = $id;
        return $this;
    }

    private function indexUri()
    {
        return str_replace('{projectId}', $this->projectId, static::INDEX_URI);
    }

    private function createUri()
    {
        return static::CREATE_URI;
    }
}