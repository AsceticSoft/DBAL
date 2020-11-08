<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Driver;

use AsceticSoft\DBAL\EventDispatcherAwareTrait;
use PDO;
use Psr\Log\LoggerAwareTrait;

abstract class AbstractDriver implements DriverInterface
{
    use LoggerAwareTrait;
    use EventDispatcherAwareTrait;

    public function createPdoInstance(
        string $dsn,
        string $username = null,
        string $passwd = null,
        array $options = []
    ): PDO {
        return new PDO($dsn, $username, $passwd, $options);
    }

    public function setTransactionIsolationLevel(PDO $pdo, string $isolationLevel): void
    {
        $pdo->exec("SET TRANSACTION ISOLATION LEVEL $isolationLevel");
    }
}
