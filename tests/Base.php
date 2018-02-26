<?php

namespace DigitalArts\Crm\SiteFormIntegration\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Base extends TestCase
{
    protected function createStreamMock($streamContent)
    {
        $stream = $this->getMockBuilder(StreamInterface::class)->getMock();
        $stream->method('getContents')->willReturn($streamContent);
        return $stream;
    }

    protected function createResponseMockFromStream(StreamInterface $stream)
    {
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $response->method('getBody')->willReturn($stream);
        return $response;
    }

    protected function createResponseMock($streamContent)
    {
        $stream = $this->createStreamMock($streamContent);
        return $this->createResponseMockFromStream($stream);
    }
}