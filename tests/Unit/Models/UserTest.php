<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests;

use DigitalArts\Crm\SiteFormIntegration\Models\User;
use GuzzleHttp\Client;

class UserTest extends Base
{
    /** @test */
    public function request_token()
    {
        $username = 'test@domain.com';
        $password = '123456';
        $loginFormData = [
            'email' => $username,
            'password' => $password
        ];
        $streamloginContent = json_encode([
            "token" => "fake_token",
            "token_type" => "bearer",
            "expires_in" => 36000
        ]);
        $responseLogin = $this->createResponseMock($streamloginContent);
        $httpLogin = $this->getMockBuilder(Client::class)
            ->setConstructorArgs([[
                'base_uri' => 'http://test.domain/api/',
            ]])
            ->getMock();
        $httpLogin->method('request')
            ->with('post', 'login', ['json' => $loginFormData])
            ->willReturn($responseLogin);
        $login = new User($httpLogin);
        $loginData = $login->token($username, $password);

        $this->assertEquals('fake_token', $loginData['token']);
        $this->assertEquals('bearer', $loginData['token_type']);
        $this->assertEquals(36000, $loginData['expires_in']);
    }
}