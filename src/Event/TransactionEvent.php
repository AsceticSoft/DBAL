<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Event;

use AsceticSoft\DBAL\Transaction;

class TransactionEvent
{
    public const EVENT_BEGIN = 'begin';
    public const EVENT_COMMIT = 'commit';
    public const EVENT_ROLLBACK = 'rollback';

    private Transaction $transaction;
    private string $event;

    public function __construct(Transaction $transaction, string $event)
    {
        $this->transaction = $transaction;
        $this->event = $event;
    }

    public function getEvent(): string
    {
        return $this->event;
    }
}
