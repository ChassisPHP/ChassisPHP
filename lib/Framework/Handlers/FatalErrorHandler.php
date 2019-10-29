<?php
namespace Lib\Framework\Handlers;

class FatalErrorHandler
{
    public function fatalErrorHandler()
    {
        $error = error_get_last();

        if ($error !== null) {
            $errorType   = $error["type"];
            $errorFile = $error["file"];
            $errorLine = $error["line"];
            $errorMessage  = $error["message"];
        }
        if (($error !== null) && ($errorType === E_ERROR)) {
            // fatal error has occured
            $logfilename = dirname(__FILE__, 4) . '/storage/logs/error.log';
            $logFile = fopen($logfilename, 'a+');
            fprintf(
                $logFile,
                "[%s] %s: %s in %s:%d\n",
                date("Y-m-d H:i:s"),
                $errorType,
                $errorMessage,
                $errorFile,
                $errorLine
            );

            fclose($logFile);

            $html = file_get_contents(dirname(__FILE__, 4) . "/resources/views/errors/500.twig");
            echo $html;
        }
    }
}
