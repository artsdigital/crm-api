<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests\Unit\Models;

use DigitalArts\Crm\SiteFormIntegration\Models\Platform;

class PlatformTest extends Base
{
    public function setUp()
    {
        parent::setUp();

        $this->setProjectId(2);
    }

    protected function getModel()
    {
        return Platform::class;
    }

    protected function getIndexUri()
    {
        return str_replace('{projectId}', $this->getProjectId(),'projects/{projectId}/platforms');
    }

    protected function getCreateUri()
    {
        return 'platforms';
    }
}