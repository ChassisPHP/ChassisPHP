<?php

namespace ChassisPHP\Framework;

use Zend\Diactoros\Stream;

class ResponseBody extends Stream
{
    public static function createFromString($body)
    {
        $tmpFile = \tmpfile();
        \fwrite($tmpFile, $body);

        return new ResponseBody($tmpFile);
    }
}
