<?php
/**
 * Created by IntelliJ IDEA.
 * User: dominik
 * Date: 10/14/18
 * Time: 8:15 AM
 */

namespace Lib\Framework\Log;

use Lib\Framework\ConfigManager;
use Lib\Framework\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Registers log handlers
 * Class LogManager
 * @package Lib\Framework\Log
 */
class LogManager implements LoggerInterface
{
    /** @var ConfigManager */
    protected $config;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * LogManager constructor.
     *
     * @param \Lib\Framework\Container $container
     * @throws \ReflectionException
     */
    public function __construct(Container $container)
    {
        $this->config = $container->get('Config');
        $this->logger = $this->bootstrap();
    }


    /**
     * Register Multiple Stream Handlers for every configured output.
     *
     * @throws \ReflectionException
     * @throws \Exception
     * @return LoggerInterface
     */
    public function bootstrap()
    {
        $logger = new Logger('CHASSISPHP');
        foreach ($this->config->get('logging.output') as $level => $name) {
            $prefix = date($this->config->get('logging.prefix.format')) . $this->config->get('logging.prefix.separator');
            $logPath = $this->config->get('logging.folder') . DIRECTORY_SEPARATOR . $prefix . $name;
            $logLevel = (new \ReflectionClass(Logger::class))->getConstant(strtoupper($level));
            $logger->pushHandler(new StreamHandler(storagePath($logPath), $logLevel));
        }
        return $logger;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function emergency($message, array $context = [])
    {
        $this->logger->emergency($message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function alert($message, array $context = [])
    {
        $this->logger->alert($message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function critical($message, array $context = [])
    {
        $this->logger->critical($message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function error($message, array $context = [])
    {
        $this->logger->error($message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function warning($message, array $context = [])
    {
        $this->logger->warning($message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function notice($message, array $context = [])
    {
        $this->logger->notice($message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function info($message, array $context = [])
    {
        $this->logger->info($message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function debug($message, array $context = [])
    {
        $this->logger->debug($message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        $this->logger->log($level, $message, $context);
    }
}