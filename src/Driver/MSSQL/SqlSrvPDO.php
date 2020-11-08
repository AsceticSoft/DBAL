<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Driver\MSSQL;

use PDO;

class SqlSrvPDO extends PDO
{
    public function lastInsertId($name = null)
    {
        return $name ? parent::lastInsertId($name) : parent::lastInsertId();
    }
}
