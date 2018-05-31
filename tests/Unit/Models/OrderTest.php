<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests\Unit\Models;

use DigitalArts\Crm\SiteFormIntegration\Models\Order;

class OrderTest extends Base
{
    public function setUp()
    {
        parent::setUp();

        $this->setProjectId(2);
    }

    protected function getModel()
    {
        return Order::class;
    }

    protected function getIndexUri()
    {
        return str_replace('{projectId}', $this->getProjectId(),'projects/{projectId}/orders');
    }

    protected function getCreateUri()
    {
        return 'orders';
    }
}