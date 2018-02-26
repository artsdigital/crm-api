<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests\Unit\Models;

use DigitalArts\Crm\SiteFormIntegration\Tests\Base as BaseTest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

abstract class Base extends BaseTest
{
    protected $httpClient;
    protected $response;
    protected $expects;

    public function setUp() /* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->expects = [
            'id' => 3,
            'name' => 'John Doe'
        ];

        $streamContent = json_encode([
            'data' => [
                $this->expects
            ]
        ]);

        $stream = $this->getMockBuilder(StreamInterface::class)->getMock();
        $stream->method('getContents')->willReturn($streamContent);

        $this->response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $this->response->method('getBody')->willReturn($stream);

        $this->httpClient = $this->getMockBuilder(\GuzzleHttp\Client::class)->setConstructorArgs([[
            'base_uri' => 'http://test.domain/api',
            'headers' => [
                "Authentication" => 'Bearer test_token'
            ]
        ]])->getMock();
    }

    /**
     * @dataProvider whereProvider
     * @test
     */
    public function first($where)
    {
        $expects = [
            'id' => 3,
            'name' => 'John Doe'
        ];

        $streamContent = json_encode([
            'data' => [
                $expects
            ]
        ]);
        $response = $this->createResponseMock($streamContent);
        $this->httpClient->method('request')->with('get', $this->getIndexUri(), $where)->willReturn($response);

        $model = $this->getModel();
        $clientModel = new $model($this->httpClient);
        $actual = $clientModel->first();
        $this->assertEquals($this->expects, $actual);
    }

    /** @test */
    public function create()
    {
        $expects = [
            'client_id' => 2,
            'lead_type_id' => 3,
            'data' => [
                'info' => 'test description'
            ]
        ];
        $create = [
            'json_data' => $expects
        ];
        $response = $this->createResponseMock(json_encode($expects));
        $this->httpClient->method('request')->with('post', $this->getCreateUri(), $create)->willReturn($response);

        $model = $this->getModel();
        $clientModel = new $model($this->httpClient);
        $actual = $clientModel->create($create);

        $this->assertEquals($expects, $actual);
    }

    /** @test */
    public function first_with_query()
    {
        $where = ['name' => 'John Doe'];
        $expects = [
            'id' => 3,
            'name' => 'John Doe'
        ];

        $streamContent = json_encode([
            'data' => [
                $expects
            ]
        ]);
        $response = $this->createResponseMock($streamContent);
        $this->httpClient->method('request')->with('get', $this->getIndexUri(), $where)->willReturn($response);

        $model = $this->getModel();
        $clientModel = new $model($this->httpClient);
        $actual = $clientModel->where($where)->first();
        $this->assertEquals($this->expects, $actual);
    }

    /** @test */
    public function where()
    {
        $client = new \GuzzleHttp\Client();
        $model = $this->getModel();
        $clientModel = new $model($client);
        $this->assertInstanceOf($this->getModel(), $clientModel->where(['name' => 'John Doe']));
        $this->assertAttributeEquals(['name' => 'John Doe'], 'where', $clientModel);
    }

    public function whereProvider()
    {
        return [
            [[]]
//            [['name' => 'John Doe']]
        ];
    }

    abstract protected function getModel();
    abstract protected function getIndexUri();
    abstract protected function getCreateUri();
}