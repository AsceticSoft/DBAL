<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Tests\PdoCommand;

use AsceticSoft\DBAL\PdoCommand\DbException;
use AsceticSoft\DBAL\PdoCommand\PdoValue;
use AsceticSoft\DBAL\Tests\TestCase;
use PDO;

class StatementTest extends TestCase
{
    /**
     * @throws DbException
     */
    public function testErrorQuery(): void
    {
        $this->expectException(DbException::class);
        $this->db->execute('select * from bad_table_name');
    }

    public function testErrorParams(): void
    {
        $this->expectException(DbException::class);
        $this->db
            ->fetch('select * from Album where AlbumId = :p1', ['p2' => 1])
            ->all();
    }

    public function testPdoValue(): void
    {
        $all = $this->db
            ->fetch('select * from Album where AlbumId = :p1', ['p1' => new PdoValue(1, PDO::PARAM_STR)])
            ->all();
        $this->assertCount(1, $all);
    }
}
