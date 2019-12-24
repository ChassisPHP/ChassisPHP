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
        $serverProps = $request->getServerParams('REQUEST_URI');
        $URI = $serverProps['REQUEST_URI'];
        if (! checkAuth()) {
            Session::setMessage('warning', 'The page you attempted to access requires that you log in ');
            Session::set('history', $URI);
            return header('Location: /backend/login');
        }
        $response = $next($request, $response);
        return $response;
    }
}
