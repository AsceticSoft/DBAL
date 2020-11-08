<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Tests;

use AsceticSoft\DBAL\Transaction;

class TransactionTestCase extends TestCase
{
    protected Transaction $transaction;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transaction = $this->db->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->transaction->rollBack();
    }
}
