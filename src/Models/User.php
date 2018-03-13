<?php

namespace DigitalArts\Crm\SiteFormIntegration\Models;

class User extends Base
{
    public function token($email, $password)
    {
        $response = $this->client->request('post', 'login', ['json' => [
            'email' => $email,
            'password' => $password
        ]]);
        $contents = json_decode($response->getBody()->getContents(), 1);
        return $contents;
    }
}