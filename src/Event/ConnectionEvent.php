<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Event;

use AsceticSoft\DBAL\Connection;

class ConnectionEvent
{
    public const EVENT_AFTER_OPEN = 'afterOpen';

    private Connection $connection;
    private string $event;

    public function __construct(Connection $connection, string $event)
    {
        $this->connection = $connection;
        $this->event = $event;
    }

    public function getEvent(): string
    {
        return $this->event;
    }
}
