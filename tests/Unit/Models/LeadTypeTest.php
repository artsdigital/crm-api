<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests\Unit\Models;

use DigitalArts\Crm\SiteFormIntegration\Models\LeadType;

class LeadTypeTest extends Base
{
    public function setUp()
    {
        parent::setUp();

        $this->setProjectId(2);
    }

    protected function getModel()
    {
        return LeadType::class;
    }

    protected function getIndexUri()
    {
        return str_replace('{projectId}', $this->getProjectId(),'projects/{projectId}/lead-types');
    }

    protected function getCreateUri()
    {
        return 'lead-types';
    }
}