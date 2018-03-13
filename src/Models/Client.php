<?php

namespace DigitalArts\Crm\SiteFormIntegration\Models;

class Client extends Base
{
    const INDEX_URI = 'projects/{projectId}/clients';
    const CREATE_URI = 'clients';

    public function addPhone($clientId, $phone)
    {
        $response = $this->client->request('post', 'clients/phones', [
            'client_id' => $clientId,
            'phone' => $phone
        ]);
        return json_decode($response->getBody()->getContents(), 1);
    }

    public function addEmail($clientId, $email)
    {
        $response = $this->client->request('post', 'clients/emails', [
            'client_id' => $clientId,
            'email' => $email
        ]);
        return json_decode($response->getBody()->getContents(), 1);
    }
}