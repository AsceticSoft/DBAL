<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Tests\PdoCommand;

use AsceticSoft\DBAL\Tests\TestCase;

class FetchTest extends TestCase
{
    public function testIndexed(): void
    {
        $all = $this->db->fetch('select Title, AlbumId from Album limit 10')->indexed();
        $this->assertCount(10, $all);
        foreach (array_keys($all) as $key) {
            $this->assertIsString($key);
        }
        $this->assertArrayNotHasKey('Title', array_shift($all));
    }

    public function testGrouped(): void
    {
        $all = $this->db->fetch('select Title, AlbumId from Album limit 10')->grouped();
        $this->assertCount(10, $all);
        foreach (array_keys($all) as $key) {
            $this->assertIsString($key);
        }
        $this->assertArrayNotHasKey('Title', array_shift($all));
    }

    public function testBatchCursor(): void
    {
        $cursor = $this->db->fetch('select * from Album')->batchCursor(25, 10);
        foreach ($cursor as $batch) {
            $this->assertCount(10, $batch);
        }
    }
}
