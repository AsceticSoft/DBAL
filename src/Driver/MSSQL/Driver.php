<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Driver\MSSQL;

use AsceticSoft\DBAL\Driver\AbstractDriver;
use AsceticSoft\DBAL\Driver\SavepointInterface;
use PDO;

class Driver extends AbstractDriver implements SavepointInterface
{
    public function createPdoInstance(
        string $dsn,
        string $username = null,
        string $passwd = null,
        array $options = []
    ): PDO {
        $driverName = explode(':', $dsn)[0];
        if ('mssql' === $driverName || 'dblib' === $driverName) {
            $pdoClass = MsSqlPDO::class;
        } elseif ('sqlsrv' === $driverName) {
            $pdoClass = SqlSrvPDO::class;
        } else {
            $pdoClass = PDO::class;
        }

        return new $pdoClass($dsn, $username, $passwd, $options);
    }

    /**
     * Creates a new savepoint.
     *
     * @param string $name the savepoint name
     */
    public function createSavepoint(PDO $pdo, string $name): void
    {
        $pdo->exec("SAVE TRANSACTION $name");
    }

    /**
     * Releases an existing savepoint.
     *
     * @param string $name the savepoint name
     */
    public function releaseSavepoint(PDO $pdo, string $name): void
    {
        // does nothing as MSSQL does not support this
    }

    /**
     * Rolls back to a previously created savepoint.
     *
     * @param string $name the savepoint name
     */
    public function rollBackSavepoint(PDO $pdo, string $name): void
    {
        $pdo->exec("ROLLBACK TRANSACTION $name");
    }
}
