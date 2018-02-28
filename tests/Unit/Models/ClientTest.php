<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests\Unit\Models;

use DigitalArts\Crm\SiteFormIntegration\Models\Client;

class ClientTest extends Base
{
    public function setUp()
    {
        parent::setUp();

        $this->setProjectId(4);
    }

    /** @test */
    public function add_phone()
    {
        $expects = [
            'client_id' => 2,
            'phone' => '987645321'
        ];
        $response = $this->createResponseMock(json_encode($expects));
        $this->httpClient->method('request')->with('post', $this->getAddPhoneUri(), $expects)->willReturn($response);

        $model = $this->getModel();
        $clientModel = new $model($this->httpClient);
        $actual = $clientModel->addPhone($expects['client_id'], $expects['phone']);

        $this->assertEquals($expects, $actual);
    }

    /** @test */
    public function add_email()
    {
        $expects = [
            'client_id' => 2,
            'email' => 'test@example.com'
        ];
        $response = $this->createResponseMock(json_encode($expects));
        $this->httpClient->method('request')->with('post', $this->getAddEmailUri(), $expects)->willReturn($response);

        $model = $this->getModel();
        $clientModel = new $model($this->httpClient);
        $actual = $clientModel->addEmail($expects['client_id'], $expects['email']);

        $this->assertEquals($expects, $actual);
    }

    protected function getModel()
    {
        return Client::class;
    }

    protected function getIndexUri()
    {
        return str_replace('{projectId}', $this->getProjectId(),'projects/{projectId}/clients');
    }

    protected function getCreateUri()
    {
        return 'clients';
    }

    private function getAddPhoneUri()
    {
        return 'clients/phones';
    }

    private function getAddEmailUri()
    {
        return 'clients/emails';
    }
}