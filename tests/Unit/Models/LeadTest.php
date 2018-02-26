<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests\Unit\Models;

use DigitalArts\Crm\SiteFormIntegration\Models\Lead;

class LeadTest extends Base
{
    protected function getModel()
    {
        return Lead::class;
    }

    protected function getIndexUri()
    {
        return 'projects/7/leads';
    }

    protected function getCreateUri()
    {
        return 'leads';
    }
}