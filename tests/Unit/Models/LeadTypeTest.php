<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests\Unit\Models;

use DigitalArts\Crm\SiteFormIntegration\Models\LeadType;

class LeadTypeTest extends Base
{
    protected function getModel()
    {
        return LeadType::class;
    }

    protected function getIndexUri()
    {
        return 'projects/7/lead-types';
    }

    protected function getCreateUri()
    {
        return 'lead-types';
    }
}