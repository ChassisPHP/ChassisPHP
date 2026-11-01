<?php

namespace Tests\Unit;

use Tests\TestCase;
use ChassisPHP\Framework\Container;

class CoreTest extends TestCase
{
    public function testGetContainer()
    {
        $app = $this->createApplication();

        $this->assertInstanceOf(Container::class, $app->getContainer());
    }

    public function testUnknownMethodThrows()
    {
        $this->expectException(\BadMethodCallException::class);

        $this->createApplication()->notAMethod();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRunSendsRouteResponse()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/hello/World';

        ob_start();
        $this->createApplication()->run();

        $this->assertSame('Hello World', ob_get_clean());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRunRendersDefaultTemplateForNotFound()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/nowhere';

        ob_start();
        $this->createApplication()->run();

        $this->assertSame("Not found\n", ob_get_clean());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testRunWithoutDefaultTemplateSendsEmptyBody()
    {
        // there is no template.defaults.405, so nothing is rendered
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/form';

        ob_start();
        $this->createApplication()->run();

        $this->assertSame('', ob_get_clean());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testBackendRoutesArePrefixedWithFileName()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/backend/login';

        ob_start();
        $this->createApplication()->run();

        $this->assertSame('login page', ob_get_clean());
    }
}
