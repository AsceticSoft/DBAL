<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL;

use Psr\EventDispatcher\EventDispatcherInterface;

trait EventDispatcherAwareTrait
{
    protected ?EventDispatcherInterface $eventDispatcher = null;

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher = $eventDispatcher;
    }
}
