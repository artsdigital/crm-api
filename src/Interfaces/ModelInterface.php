<?php

namespace DigitalArts\Crm\SiteFormIntegration\Interfaces;

interface ModelInterface
{
    public function create($parameters);
    public function where($parameters);
    public function first();
}