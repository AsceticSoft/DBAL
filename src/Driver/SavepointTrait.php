<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Driver;

use PDO;

trait SavepointTrait
{
    /**
     * Creates a new savepoint.
     *
     * @param string $name the savepoint name
     */
    public function createSavepoint(PDO $pdo, string $name): void
    {
        $pdo->exec("SAVEPOINT $name");
    }

    /**
     * Releases an existing savepoint.
     *
     * @param string $name the savepoint name
     */
    public function releaseSavepoint(PDO $pdo, string $name): void
    {
        $pdo->exec("RELEASE SAVEPOINT $name");
    }

    /**
     * Rolls back to a previously created savepoint.
     *
     * @param string $name the savepoint name
     */
    public function rollBackSavepoint(PDO $pdo, string $name): void
    {
        $pdo->exec("ROLLBACK TO SAVEPOINT $name");
    }
}
