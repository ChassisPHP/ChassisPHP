<?PHP

namespace Tests\RoutesTest;

use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class RoutesTest extends TestCase
{
    public function testBasicRouting()
    {
        $app = $this->StartInstance();
        $app->addRoute('GET', '/', function () {
            return new Response('TEST');
        });
        $response = $app->run();
        $responseContent = $response->getContent();
        $this->assertContains($responseContent, 'TEST');
    }
}
