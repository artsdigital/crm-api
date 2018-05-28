<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests\Unit\Models;

use DigitalArts\Crm\SiteFormIntegration\Models\Contractor;

class ContractorTest extends Base
{
    public function setUp()
    {
        parent::setUp();

        $this->setProjectId(2);
    }

    protected function getModel()
    {
        return Contractor::class;
    }

    protected function getIndexUri()
    {
        return str_replace('{projectId}', $this->getProjectId(),'projects/{projectId}/contractors');
    }

    protected function getCreateUri()
    {
        return 'contractors';
    }
}
