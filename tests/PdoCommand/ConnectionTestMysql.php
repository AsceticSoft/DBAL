<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Tests\PdoCommand;

use AsceticSoft\DBAL\NotSupportedException;
use AsceticSoft\DBAL\PdoCommand\DbException;
use AsceticSoft\DBAL\Tests\TestCase;
use AsceticSoft\DBAL\Transaction;

class ConnectionTestMysql extends TestCase
{
    /**
     * @throws DbException
     * @throws NotSupportedException
     */
    public function testIsolationLevel(): void
    {
        $db1 = $this->createConnection();
        $db2 = $this->createConnection();
        $db1->setTransactionIsolationLevel(Transaction::READ_UNCOMMITTED);
        $db2->setTransactionIsolationLevel(Transaction::READ_UNCOMMITTED);
        $tran = $db2->beginTransaction();
        $count = $db2->execute('update Album set Title = :p1 where AlbumId = :p2', ['p1' => 'test1', 'p2' => 1]);
        $this->assertEquals(1, $count);
        $title = $db1->fetch('select Title from Album where AlbumId = :p1', ['p1' => 1])->scalar();
        $this->assertEquals('test1', $title);
        $tran->rollBack();
    }
}
