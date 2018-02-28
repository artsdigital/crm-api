<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests\Feature;

use DigitalArts\Crm\SiteFormIntegration\Models\Client;
use DigitalArts\Crm\SiteFormIntegration\Models\Lead;
use DigitalArts\Crm\SiteFormIntegration\Models\LeadType;
use DigitalArts\Crm\SiteFormIntegration\Models\User;
use DigitalArts\Crm\SiteFormIntegration\Tests\Base;
use GuzzleHttp\Client as Guzzle;

class SendFormToCrmTest extends Base
{
    /** @test */
    public function success_send_to_crm()
    {
        $data = array(
            'name' => 'John Doe',
            'phone' => '+1 (234) 567-89-01',
            'email' => 'john.doe@test.com',
            'message' => 'Test message',
            'type' => 'New Lead Type'
        );

        $streamClientContent = json_encode([
            'data' => [
                [
                    "id" => 1,
                    'name' => $data['name'],
                    "phones" => [
                        [
                            "phone" => 12345678901,
                            "client_id" => 1
                        ]
                    ],
                ]
            ]
        ]);
        $streamLeadTypeContent = json_encode([
            'data' => [
                [
                    "id" => 1,
                    'name' => $data['type'],
                ]
            ]
        ]);

        $leadDescription = '';
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'name':
                    $ruName = 'Имя';
                    break;
                case 'phone':
                    $ruName = 'Телефон';
                    break;
                case 'email':
                    $ruName = 'E-mail';
                    break;
                case 'message':
                    $ruName = 'Сообщение';
                    break;
                default:
                    $ruName = 'Неизвестное поле';
                    break;
            }
            $leadDescription .= "$ruName: $value\n\r";
        }
        $expect = [
            'client_id' => 1,
            'lead_type_id' => 1,
            'data' => [
                'description' => $leadDescription
            ]
        ];
        $streamLeadContent = json_encode($expect);

        $username = 'test@domain.com';
        $password = '123456';
        $loginFormData = [
            'email' => 'test@domain.com',
            'password' => '123456'
        ];
        $streamloginContent = json_encode([
            "token" => "fake_token",
            "token_type" => "bearer",
            "expires_in" => 36000
        ]);
        $responseLogin = $this->createResponseMock($streamloginContent);
        $httpLogin = $this->getMockBuilder(Guzzle::class)
            ->setConstructorArgs([[
                'base_uri' => 'http://test.domain/api'
            ]])
            ->getMock();
        $httpLogin->method('request')
            ->with('post', 'login', ['json' => $loginFormData])
            ->willReturn($responseLogin);
        $login = new User($httpLogin);
        $loginData = $login->token($username, $password);

        $this->assertEquals('fake_token', $loginData['token']);
        $httpBuilder = $this->getMockBuilder(Guzzle::class)->setConstructorArgs([[
            'base_uri' => 'http://test.domain/api',
            'headers' => [
                "Authorization" => 'Bearer ' . $loginData['token']
            ]
        ]]);

        $responseClient = $this->createResponseMock($streamClientContent);
        $httpClient = $httpBuilder->getMock();
        $httpClient->method('request')->with('get', 'projects/7/clients', ['json' => ['phone' => '12345678901']])->willReturn($responseClient);

        $responseLeadType = $this->createResponseMock($streamLeadTypeContent);
        $httpLeadType = $httpBuilder->getMock();
        $httpLeadType->method('request')->with('get', 'projects/7/lead-types', ['json' => ['name' => 'New Lead Type']])->willReturn($responseLeadType);

        $responseLead = $this->createResponseMock($streamLeadContent);
        $httpLead = $httpBuilder->getMock();
        $httpLead->method('request')->with('post', 'leads', ['json' => $expect])->willReturn($responseLead);

        $clientModel = new Client($httpClient);
        $leadTypeModel = new LeadType($httpLeadType);
        $leadModel = new Lead($httpLead);

        $clientModel->setProjectId(7);
        $leadTypeModel->setProjectId(7);

        $clientInfo = $clientModel->where(['phone' => str_replace(['+', '(', ')', '-', ' '], '', $data['phone'])])->first();
        $leadTypeInfo = $leadTypeModel->where(['name' => $data['type']])->first();

        $lead = $leadModel->create([
            'client_id' => $clientInfo['id'],
            'lead_type_id' => $leadTypeInfo['id'],
            'data' => [
                'description' => $leadDescription
            ]
        ]);

        $this->assertEquals($expect, $lead);
    }
}

