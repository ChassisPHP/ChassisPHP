<?php

namespace Tests\RoutesTest;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class RoutesTest extends TestCase
{
    public function testBasicRouting()
    {
        $app = $this->createApplication();
        $app->addRoute('GET', '/routetest', function () {
            return new Response('TEST');
        });

        $container = $app->getContainer();
        $request = $container->get('Request');
        $request->duplicate(null, null, null, null, null, array('REQUEST_URI' => '/routetest', 'HTTP_HOST' => '192.168.1.10'));
        $response = $app->run();
        $responseContent = $response->getContent();
        $responseStatus = $response->getStatusCode();
        $this->assertEquals($responseStatus, 200);
    }
}
