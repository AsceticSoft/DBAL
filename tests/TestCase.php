<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Tests;

use AsceticSoft\DBAL\Connection;
use AsceticSoft\DBAL\NotSupportedException;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * @throws NotSupportedException
     */
    protected function setUp(): void
    {
        static $connection;
        if (!$connection) {
            $connection = $this->createConnection();
        }
        $this->db = $connection;
    }

    /**
     * @param $dsn
     *
     * @throws NotSupportedException
     */
    protected function createConnection(): Connection
    {
        return (new TestConnectionFactory())->create();
//
//        $connection = new Connection('sqlite::memory:');
//        $pdo = $connection->getPdo();
//        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $sql = file_get_contents(__DIR__ . '/db/chinook_sqlite.sql');
//        $pdo->exec($sql);
//        return $connection;
    }
}
