<?php

namespace Tests\Unit;

use Tests\TestCase;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequest;
use ChassisPHP\Framework\Http\MiddlewareQueue;

class MiddlewareQueueTest extends TestCase
{
    private $request;
    private $response;
    private $queue;

    public function setUp(): void
    {
        $this->request = new ServerRequest();
        $this->response = new Response();
        $this->queue = new MiddlewareQueue($this->request, $this->response);
    }

    public function testControllerOnly()
    {
        $this->queue->addController('content');

        $response = $this->queue->callMiddleware($this->request, $this->response);

        $this->assertSame('content', (string) $response->getBody());
    }

    public function testLastAddedMiddlewareRunsFirstAndControllerRunsLast()
    {
        $this->queue->addMiddleware('FirstMiddleware', '\Tests\Support\Middleware\\');
        $this->queue->addMiddleware('SecondMiddleware', '\Tests\Support\Middleware\\');
        $this->queue->addController('content');

        $response = $this->queue->callMiddleware($this->request, $this->response);

        $this->assertSame('second;first;content', (string) $response->getBody());
    }

    public function testAddMiddlewareReturnsQueue()
    {
        $queue = $this->queue->addMiddleware('FirstMiddleware', '\Tests\Support\Middleware\\');

        $this->assertCount(1, $queue);
    }
}
