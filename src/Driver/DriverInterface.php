<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Driver;

use AsceticSoft\DBAL\EventDispatcherAwareInterface;
use PDO;
use Psr\Log\LoggerAwareInterface;

interface DriverInterface extends LoggerAwareInterface, EventDispatcherAwareInterface
{
    public function createPdoInstance(
        string $dsn,
        ?string $username = null,
        ?string $passwd = null,
        array $options = []
    ): PDO;

    /**
     * Sets transaction isolation level of the db connection.
     */
    public function setTransactionIsolationLevel(PDO $pdo, string $isolationLevel);
}
