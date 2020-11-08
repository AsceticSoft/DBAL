<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Tests\PdoCommand;

use AsceticSoft\DBAL\Tests\TestCase;

class BatchCursorTest extends TestCase
{
    public function testBatch(): void
    {
        $cursor = $this->db->fetch('select * from Album')->batchCursor();


        foreach ($cursor as $array) {
            $this->assertIsArray($array);
            $this->assertCount(25, $array);
            break;
        }
    }
}
