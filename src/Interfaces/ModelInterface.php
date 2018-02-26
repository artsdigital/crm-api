<?php

namespace DigitalArts\Crm\SiteFormIntegration\Interfaces;

interface ModelInterface
{
    public function create(array $parameters): array;
    public function where(array $parameters);
    public function first(): array;
}