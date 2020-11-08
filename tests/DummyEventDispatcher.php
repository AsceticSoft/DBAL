<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Tests;

use Psr\EventDispatcher\EventDispatcherInterface;

class DummyEventDispatcher implements EventDispatcherInterface
{
    private array $dispatched = [];

    /**
     * Provide all relevant listeners with an event to process.
     *
     * @param object $event
     *                      The object to process
     *
     * @return object
     *                The Event that was passed, now modified by listeners
     */
    public function dispatch(object $event)
    {
        $this->dispatched[] = $event;

        return $event;
    }

    public function getDispatched(): array
    {
        return $this->dispatched;
    }
}
