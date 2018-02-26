<?php

namespace DigitalArts\Crm\SiteFormIntegration\Models;

class Client extends Base
{
    const INDEX_URI = 'projects/7/clients';
    const CREATE_URI = 'clients';

    public function addPhone(int $clientId, string $phone): array
    {
        $response = $this->client->request('post', 'clients/phones', [
            'client_id' => $clientId,
            'phone' => $phone
        ]);
        return json_decode($response->getBody()->getContents(), 1);
    }

    public function addEmail(int $clientId, string $email): array
    {
        $response = $this->client->request('post', 'clients/emails', [
            'client_id' => $clientId,
            'email' => $email
        ]);
        return json_decode($response->getBody()->getContents(), 1);
    }
}