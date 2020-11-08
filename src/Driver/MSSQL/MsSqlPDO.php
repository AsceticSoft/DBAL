<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Driver\MSSQL;

use PDO;
use PDOException;

class MsSqlPDO extends PDO
{
    public function lastInsertId($name = null)
    {
        return $this->query('SELECT CAST(COALESCE(SCOPE_IDENTITY(), @@IDENTITY) AS bigint)')->fetchColumn();
    }

    public function beginTransaction()
    {
        $this->exec('BEGIN TRANSACTION');

        return true;
    }

    public function commit()
    {
        $this->exec('COMMIT TRANSACTION');

        return true;
    }

    public function rollBack()
    {
        $this->exec('ROLLBACK TRANSACTION');

        return true;
    }

    public function getAttribute($attribute)
    {
        try {
            return parent::getAttribute($attribute);
        } catch (PDOException $e) {
            switch ($attribute) {
                case self::ATTR_SERVER_VERSION:
                    return $this->query("SELECT CAST(SERVERPROPERTY('productversion') AS VARCHAR)")->fetchColumn();
                default:
                    throw $e;
            }
        }
    }
}
