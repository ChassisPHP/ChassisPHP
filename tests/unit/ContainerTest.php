<?php

namespace Tests\Unit;

use Tests\TestCase;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ChassisPHP\Framework\Router;
use ChassisPHP\Framework\Container;
use ChassisPHP\Framework\Connection;
use ChassisPHP\Framework\ConfigManager;
use ChassisPHP\Framework\Services\Mailer;
use ChassisPHP\Framework\Http\MiddlewareQueue;
use App\Http\Controllers\HomeController;

class ContainerTest extends TestCase
{
    private $container;

    public function setUp(): void
    {
        $this->container = new Container();
    }

    public function testBaseDirIsAppRoot()
    {
        $this->assertSame(APP_ROOT, $this->container->get('BaseDir'));
    }

    public function testPsr7Services()
    {
        $this->assertInstanceOf(ServerRequestInterface::class, $this->container->get('PsrRequestInterface'));
        $this->assertInstanceOf(ResponseInterface::class, $this->container->get('PsrResponseInterface'));
    }

    public function testMiddlewareQueueIsShared()
    {
        $queue = $this->container->get('MiddlewareQueue');

        $this->assertInstanceOf(MiddlewareQueue::class, $queue);
        $this->assertSame($queue, $this->container->get('MiddlewareQueue'));
    }

    public function testRouter()
    {
        $this->assertInstanceOf(Router::class, $this->container->get('Router'));
    }

    public function testConfig()
    {
        $this->assertSame(ConfigManager::instance(), $this->container->get('Config'));
    }

    public function testDotenvPopulatesGetenv()
    {
        // The skeleton's Config files read settings with getenv()
        $this->container->get('Dotenv');

        $this->assertSame('loaded', getenv('CHASSIS_TEST_ENV'));
        $this->assertSame('loaded', envar('CHASSIS_TEST_ENV'));
    }

    public function testTwigIsSharedAndHasSupportAddress()
    {
        $twig = $this->container->get('Twig');

        $this->assertInstanceOf(\Twig\Environment::class, $twig);
        $this->assertSame($twig, $this->container->get('Twig'));
        $this->assertSame('support@example.com', $twig->getGlobals()['supportAddress']);
    }

    public function testLogger()
    {
        $this->assertInstanceOf(LoggerInterface::class, $this->container->get('Logger'));
    }

    public function testMailer()
    {
        $this->assertInstanceOf(Mailer::class, $this->container->get('Mailer'));
    }

    public function testConnectionExposesEntityManager()
    {
        $connection = $this->container->get('Connection');

        $this->assertInstanceOf(Connection::class, $connection);
        $this->assertTrue(property_exists(Connection::class, 'entityManager'));
        $this->assertInstanceOf(EntityManager::class, $connection->entityManager);
    }

    public function testDefaultErrorTemplate()
    {
        $this->assertSame('errors/404.html', $this->container->get('template.defaults.404'));
    }

    public function testControllersAreAutoRegisteredWithDependencies()
    {
        $controller = $this->container->get(HomeController::class);

        $this->assertInstanceOf(HomeController::class, $controller);
        $this->assertSame("Home of Chassis\n", $controller->index([]));
    }
}
