<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Tests\PdoCommand;

use AsceticSoft\DBAL\NotSupportedException;
use AsceticSoft\DBAL\Tests\TestCase;
use AsceticSoft\DBAL\Transaction;

class ConnectionTestSqlite extends TestCase
{
    public function testError(): void
    {
        $this->expectException(NotSupportedException::class);
        $this->db->setTransactionIsolationLevel(Transaction::REPEATABLE_READ);
    }

//    /**
//     * @throws DbException
//     * @throws NotSupportedException
//     */
//    public function testIsolationLevel()
//    {
//        $dsn = 'sqlite:' . __DIR__ . '/../db/chinook.db';
//        $db1 = $this->createConnection($dsn);
//        $db2 = new Connection($dsn);
//        $db2->getPdo()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $db1->setTransactionIsolationLevel(Transaction::READ_UNCOMMITTED);
//        $db2->setTransactionIsolationLevel(Transaction::READ_UNCOMMITTED);
//        $tran = $db2->beginTransaction();
//        $count = (new Statement($db2->getPdo(), 'update Album set Title = :p1 where AlbumId = :p2'))
//            ->execute(['p1' => 'test','p2' => 1])
//            ->rowCount();
//        $this->assertEquals($count, 1);
//        $title = (new SelectQuery($db1))
//            ->select('Title')
//            ->from('Album')
//            ->where()->equal('AlbumId', 1)
//            ->fetch()
//            ->scalar();
//        $this->assertEquals('test', $title);
//        $tran->rollBack();
//    }
}
