<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Tests\PdoCommand;

use AsceticSoft\DBAL\PdoCommand\DbException;
use AsceticSoft\DBAL\PdoCommand\Statement;
use AsceticSoft\DBAL\Tests\TestCase;
use PDO;

class StatementTestSqlite extends TestCase
{
//    public function testErrorExecute()
//    {
//        $statement = new Statement(
//            $this->connection->getPdo(),
//            'select * from Album where AlbumId=:p12',
//            [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]
//        );
//        $this->expectException(DbException::class);
//        $cursor = (new Fetch($statement))->cursor(['p12' => false]);
//        $rows = [];
//        foreach ($cursor as $value) {
//            $rows[] = $value;
//        }
//    }

    /**
     * @throws DbException
     */
    public function testErrorOptions(): void
    {
        $this->expectException(DbException::class);
        (new Statement(
            $this->db->getPdo(),
            'select * from Album',
            [PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]
        ))
            ->execute();
    }

    /**
     * @throws DbException
     */
    public function testErrorExecute(): void
    {
        $this->expectException(DbException::class);
        (new Statement($this->db->getPdo(), 'select * from Album where AlbumId=1111111111111111111'))
            ->execute(['p1' => '1222222222222222222'])->fetchAll();
    }
}
