<?PHP

namespace Lib\Framework\Http\Middleware;

use Lib\Framework\Session;

class AuthMiddleware
{
    /**
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     **/
    public function __invoke($request, $response, $next = null)
    {
        if (!Session::get('authenticated')) {
            // user is authenticated
            // TODO refaactor this to a helper class with more functionality
            // also, add flash message
            return header('Location: /backend/login');
        }
        $response = $next($request, $response);
        return $response;
    }
}
