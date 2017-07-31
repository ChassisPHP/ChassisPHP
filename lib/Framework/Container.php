<?php

namespace \lib\Framework

use \League\Container\Container

    class Container {

        public $container

        public function __contstruct ()
        {
            $this->container = new Container;
        }

        public function getContainer ()
        {
            return $this->container;
        }
    }

