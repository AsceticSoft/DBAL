<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Tests;

use Psr\Log\LoggerInterface;

class DummyLogger implements LoggerInterface
{
    private $logs;

    /**
     * System is unusable.
     *
     * @param string $message
     */
    public function emergency($message, array $context = []): void
    {
        $this->logs['emergency'][] = $message;
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     */
    public function alert($message, array $context = []): void
    {
        $this->logs['alert'][] = $message;
    }

    /**
     * Critical Condition.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     */
    public function critical($message, array $context = []): void
    {
        $this->logs['critical'][] = $message;
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     */
    public function error($message, array $context = []): void
    {
        $this->logs['error'][] = $message;
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     */
    public function warning($message, array $context = []): void
    {
        $this->logs['warning'][] = $message;
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     */
    public function notice($message, array $context = []): void
    {
        $this->logs['notice'][] = $message;
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     */
    public function info($message, array $context = []): void
    {
        $this->logs['info'][] = $message;
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     */
    public function debug($message, array $context = []): void
    {
        $this->logs['debug'][] = $message;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     */
    public function log($level, $message, array $context = []): void
    {
        $this->logs[$level][] = $message;
    }

    /**
     * @return mixed
     */
    public function getLogs()
    {
        return $this->logs;
    }
}
