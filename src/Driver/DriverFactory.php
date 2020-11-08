<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Driver;

use AsceticSoft\DBAL\NotSupportedException;

class DriverFactory
{
    private static array $driverMap = [
        'pgsql' => 'AsceticSoft\DBAL\Driver\Postgres\Driver', // PostgreSQL
        'mysqli' => 'AsceticSoft\DBAL\Driver\MySQL\Driver', // MySQL
        'mysql' => 'AsceticSoft\DBAL\Driver\MySQL\Driver', // MySQL
        'sqlite' => 'AsceticSoft\DBAL\Driver\Sqlite\Driver', // sqlite 3
        'sqlite2' => 'AsceticSoft\DBAL\Driver\Sqlite\Driver', // sqlite 2
        'sqlsrv' => 'AsceticSoft\DBAL\Driver\MSSQL\Driver', // newer MSSQL driver on MS Windows hosts
        'mssql' => 'AsceticSoft\DBAL\Driver\MSSQL\Driver', // older MSSQL driver on MS Windows hosts
        'dblib' => 'AsceticSoft\DBAL\Driver\MSSQL\Driver', // dblib drivers on GNU/Linux (and maybe other OSes) hosts
        'oci' => 'AsceticSoft\DBAL\Driver\Oracle\Driver', // Oracle driver
        'cubrid' => 'AsceticSoft\DBAL\Driver\CUBRID\Driver', // CUBRID
    ];

    /**
     * @param $dsn
     *
     * @throws NotSupportedException
     */
    public function __invoke($dsn): DriverInterface
    {
        $driver = explode(':', $dsn)[0];
        if (!$classname = static::$driverMap[$driver] ?? null) {
            throw new NotSupportedException();
        }
        /* @var DriverInterface $instance */
        return new $classname();
    }
}
