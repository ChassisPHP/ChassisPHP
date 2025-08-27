<?php
// tests/Mocks/PSR7Mocks.php
// Lightweight PSR-7 interface mocks for isolated unit testing

namespace Psr\Http\Message {

    if (!interface_exists('MessageInterface')) {
        interface MessageInterface
        {
            public function getProtocolVersion();
            public function withProtocolVersion($version);
            public function getHeaders();
            public function hasHeader($name);
            public function getHeader($name);
            public function getHeaderLine($name);
            public function withHeader($name, $value);
            public function withAddedHeader($name, $value);
            public function withoutHeader($name);
            public function getBody();
            public function withBody(StreamInterface $body);
        }
    }

    if (!interface_exists('RequestInterface')) {
        interface RequestInterface extends MessageInterface
        {
            public function getRequestTarget();
            public function withRequestTarget($requestTarget);
            public function getMethod();
            public function withMethod($method);
            public function getUri();
            public function withUri(UriInterface $uri, $preserveHost = false);
        }
    }

    if (!interface_exists('ServerRequestInterface')) {
        interface ServerRequestInterface extends RequestInterface
        {
            public function getServerParams();
            public function getCookieParams();
            public function withCookieParams(array $cookies);
            public function getQueryParams();
            public function withQueryParams(array $query);
            public function getUploadedFiles();
            public function withUploadedFiles(array $uploadedFiles);
            public function getParsedBody();
            public function withParsedBody($data);
            public function getAttributes();
            public function getAttribute($name, $default = null);
            public function withAttribute($name, $value);
            public function withoutAttribute($name);
        }
    }

    if (!interface_exists('ResponseInterface')) {
        interface ResponseInterface extends MessageInterface
        {
            public function getStatusCode();
            public function withStatus($code, $reasonPhrase = '');
            public function getReasonPhrase();
        }
    }

    if (!interface_exists('StreamInterface')) {
        interface StreamInterface
        {
            public function __toString();
            public function close();
            public function detach();
            public function getSize();
            public function tell();
            public function eof();
            public function isSeekable();
            public function seek($offset, $whence = SEEK_SET);
            public function rewind();
            public function isWritable();
            public function write($string);
            public function isReadable();
            public function read($length);
            public function getContents();
            public function getMetadata($key = null);
        }
    }

    if (!interface_exists('UriInterface')) {
        interface UriInterface
        {
            public function getScheme();
            public function getAuthority();
            public function getUserInfo();
            public function getHost();
            public function getPort();
            public function getPath();
            public function getQuery();
            public function getFragment();
            public function withScheme($scheme);
            public function withUserInfo($user, $password = null);
            public function withHost($host);
            public function withPort($port);
            public function withPath($path);
            public function withQuery($query);
            public function withFragment($fragment);
            public function __toString();
        }
    }
}

namespace Tests\Mocks {

    use Psr\Http\Message\ServerRequestInterface;
    use Psr\Http\Message\ResponseInterface;
    use Psr\Http\Message\StreamInterface;
    use Psr\Http\Message\UriInterface;

    /**
     * Simple mock ServerRequest for unit testing
     */
    class MockServerRequest implements ServerRequestInterface
    {
        private $method = 'GET';
        private $uri;
        private $headers = [];
        private $body;
        private $serverParams = [];

        public function __construct($method = 'GET', $uri = '/', array $headers = [])
        {
            $this->method = $method;
            $this->uri = new MockUri($uri);
            $this->headers = $headers;
            $this->body = new MockStream('');
            $this->serverParams = [
                'REQUEST_METHOD' => $method,
                'REQUEST_URI' => $uri,
            ];
        }

        public function getMethod() { return $this->method; }
        public function getServerParams() { return $this->serverParams; }
        public function getHeaders() { return $this->headers; }
        public function getHeader($name) { return $this->headers[$name] ?? []; }
        public function hasHeader($name) { return isset($this->headers[$name]); }
        public function withHeader($name, $value) { 
            $new = clone $this;
            $new->headers[$name] = (array) $value;
            return $new;
        }
        public function getBody() { return $this->body; }
        public function getUri() { return $this->uri; }
        
        // Minimal implementations for interface compliance
        public function getProtocolVersion() { return '1.1'; }
        public function withProtocolVersion($version) { return clone $this; }
        public function getHeaderLine($name) { return implode(',', $this->getHeader($name)); }
        public function withAddedHeader($name, $value) { return $this->withHeader($name, $value); }
        public function withoutHeader($name) { $new = clone $this; unset($new->headers[$name]); return $new; }
        public function withBody(StreamInterface $body) { $new = clone $this; $new->body = $body; return $new; }
        public function getRequestTarget() { return (string) $this->uri; }
        public function withRequestTarget($requestTarget) { return clone $this; }
        public function withMethod($method) { $new = clone $this; $new->method = $method; return $new; }
        public function withUri(UriInterface $uri, $preserveHost = false) { $new = clone $this; $new->uri = $uri; return $new; }
        public function getCookieParams() { return []; }
        public function withCookieParams(array $cookies) { return clone $this; }
        public function getQueryParams() { return []; }
        public function withQueryParams(array $query) { return clone $this; }
        public function getUploadedFiles() { return []; }
        public function withUploadedFiles(array $uploadedFiles) { return clone $this; }
        public function getParsedBody() { return null; }
        public function withParsedBody($data) { return clone $this; }
        public function getAttributes() { return []; }
        public function getAttribute($name, $default = null) { return $default; }
        public function withAttribute($name, $value) { return clone $this; }
        public function withoutAttribute($name) { return clone $this; }
    }

    /**
     * Simple mock Response for unit testing
     */
    class MockResponse implements ResponseInterface
    {
        private $statusCode = 200;
        private $headers = [];
        private $body;

        public function __construct($status = 200, array $headers = [])
        {
            $this->statusCode = $status;
            $this->headers = $headers;
            $this->body = new MockStream('');
        }

        public function getStatusCode() { return $this->statusCode; }
        public function withStatus($code, $reasonPhrase = '') {
            $new = clone $this;
            $new->statusCode = $code;
            return $new;
        }
        public function getReasonPhrase() { return 'OK'; }
        public function getHeaders() { return $this->headers; }
        public function withHeader($name, $value) { 
            $new = clone $this;
            $new->headers[$name] = (array) $value;
            return $new;
        }
        public function getBody() { return $this->body; }
        
        // Minimal implementations
        public function getProtocolVersion() { return '1.1'; }
        public function withProtocolVersion($version) { return clone $this; }
        public function hasHeader($name) { return isset($this->headers[$name]); }
        public function getHeader($name) { return $this->headers[$name] ?? []; }
        public function getHeaderLine($name) { return implode(',', $this->getHeader($name)); }
        public function withAddedHeader($name, $value) { return $this->withHeader($name, $value); }
        public function withoutHeader($name) { $new = clone $this; unset($new->headers[$name]); return $new; }
        public function withBody(StreamInterface $body) { $new = clone $this; $new->body = $body; return $new; }
    }

    /**
     * Simple mock Stream for unit testing
     */
    class MockStream implements StreamInterface
    {
        private $content;

        public function __construct($content = '')
        {
            $this->content = (string) $content;
        }

        public function __toString() { return $this->content; }
        public function getContents() { return $this->content; }
        
        // Minimal implementations
        public function close() {}
        public function detach() { return null; }
        public function getSize() { return strlen($this->content); }
        public function tell() { return 0; }
        public function eof() { return true; }
        public function isSeekable() { return false; }
        public function seek($offset, $whence = SEEK_SET) {}
        public function rewind() {}
        public function isWritable() { return false; }
        public function write($string) { return 0; }
        public function isReadable() { return true; }
        public function read($length) { return $this->content; }
        public function getMetadata($key = null) { return null; }
    }

    /**
     * Simple mock URI for unit testing
     */
    class MockUri implements UriInterface
    {
        private $path = '/';

        public function __construct($uri = '/')
        {
            $this->path = $uri;
        }

        public function getPath() { return $this->path; }
        public function __toString() { return $this->path; }
        
        // Minimal implementations
        public function getScheme() { return 'http'; }
        public function getAuthority() { return 'localhost'; }
        public function getUserInfo() { return ''; }
        public function getHost() { return 'localhost'; }
        public function getPort() { return 80; }
        public function getQuery() { return ''; }
        public function getFragment() { return ''; }
        public function withScheme($scheme) { return clone $this; }
        public function withUserInfo($user, $password = null) { return clone $this; }
        public function withHost($host) { return clone $this; }
        public function withPort($port) { return clone $this; }
        public function withPath($path) { $new = clone $this; $new->path = $path; return $new; }
        public function withQuery($query) { return clone $this; }
        public function withFragment($fragment) { return clone $this; }
    }
}