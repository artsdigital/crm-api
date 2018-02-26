<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests\Unit\Models;

use DigitalArts\Crm\SiteFormIntegration\Models\Client;

class ClientTest extends Base
{
    protected function getModel()
    {
        return Client::class;
    }

    protected function getIndexUri()
    {
        return 'projects/7/clients';
    }

    protected function getCreateUri()
    {
        return 'clients';
    }
}