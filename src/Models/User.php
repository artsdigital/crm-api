<?php

namespace DigitalArts\Crm\SiteFormIntegration\Models;

class User extends Base
{
    public function token(string $email, string $password): array
    {
        $response = $this->client->request('post', 'login', [
            'email' => $email,
            'password' => $password
        ]);
        $contents = json_decode($response->getBody()->getContents(), 1);
        return $contents;
    }
}