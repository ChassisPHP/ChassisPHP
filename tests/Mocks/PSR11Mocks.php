<?php
// tests/Mocks/PSR11Mocks.php
// PSR-11 Container interface mocks

namespace Psr\Container {

    if (!interface_exists('ContainerInterface')) {
        interface ContainerInterface
        {
            public function get($id);
            public function has($id);
        }
    }

    if (!interface_exists('NotFoundExceptionInterface')) {
        interface NotFoundExceptionInterface extends \Throwable
        {
        }
    }

    if (!class_exists('NotFoundException')) {
        class NotFoundException extends \Exception implements NotFoundExceptionInterface
        {
        }
    }
}