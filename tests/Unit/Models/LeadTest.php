<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests\Unit\Models;

use DigitalArts\Crm\SiteFormIntegration\Models\Lead;

class LeadTest extends Base
{
    public function setUp()
    {
        parent::setUp();

        $this->setProjectId(1);
    }

    protected function getModel()
    {
        return Lead::class;
    }

    protected function getIndexUri()
    {
        return str_replace('{projectId}', $this->getProjectId(),'projects/{projectId}/leads');
    }

    protected function getCreateUri()
    {
        return 'leads';
    }
}