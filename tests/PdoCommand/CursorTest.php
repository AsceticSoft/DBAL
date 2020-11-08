<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Tests\PdoCommand;

use AsceticSoft\DBAL\Tests\TestCase;

class CursorTest extends TestCase
{
    public function testCursor(): void
    {
        $count = $this->db->fetch('select count(*) from Album')->scalar();
        $cursor = $this->db->fetch('select * from Album')->cursor();
        $array = iterator_to_array($cursor);
        $this->assertIsArray($array);
        $this->assertCount((int) $count, $array);
    }

    public function testLimit(): void
    {
        $cursor = $this->db->fetch('select * from Album')->cursor(10);
        $array = iterator_to_array($cursor);
        $this->assertIsArray($array);
        $this->assertCount(10, $array);
    }
}
