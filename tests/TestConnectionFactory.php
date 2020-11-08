<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Tests;

use AsceticSoft\DBAL\Connection;
use AsceticSoft\DBAL\NotSupportedException;
use PDO;
use PDOException;

class TestConnectionFactory
{
    /**
     * @var array|false|string
     */
    private $driver;

    private function getTestDriverMap()
    {
        $mysqlHost = getenv('MYSQL_HOST');
        $pgsqlHost = getenv('POSTGRES_HOST');

        return [
            'sqlite' => [
                'dsn' => 'sqlite::memory:',
                'options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
                'migration' => __DIR__.'/db/chinook_sqlite.sql',
            ],
            'pgsql' => [
                'dsn' => "pgsql:host=$pgsqlHost;port=5432;dbname=chinook;",
                'username' => getenv('POSTGRES_USER'),
                'password' => getenv('POSTGRES_PASSWORD'),
                'options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
                'migration' => __DIR__.'/db/chinook_postgres.sql',
            ],
            'mysql' => [
                'dsn' => "mysql:host=$mysqlHost;port=3306;dbname=chinook;",
                'username' => getenv('MYSQL_USER'),
                'password' => getenv('MYSQL_PASSWORD'),
                'options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
                'migration' => __DIR__.'/db/chinook_mysql.sql',
            ],
        ];
    }

    public function __construct()
    {
        $this->driver = getenv('DB_ENGINE') ?: 'sqlite';
    }

    /**
     * @throws NotSupportedException
     */
    public function create(): Connection
    {
        $params = $this->getTestDriverMap()[$this->driver] ?? [];
        if (!$params) {
            throw new NotSupportedException();
        }
        $connection = new Connection(
            $params['dsn'],
            $params['username'] ?? null,
            $params['password'] ?? null,
            $params['options'] ?? []
        );
        $pdo = $connection->getPdo();
        try {
            $pdo->query('select count(*) from Album');
        } catch (PDOException $exception) {
            $sql = file_get_contents($params['migration']);
            $pdo->exec($sql);
        }

        return $connection;
    }
}
