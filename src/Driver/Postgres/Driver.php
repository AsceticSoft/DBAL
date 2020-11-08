<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\Driver\Postgres;

use AsceticSoft\DBAL\Driver\AbstractDriver;
use AsceticSoft\DBAL\Driver\SavepointInterface;
use AsceticSoft\DBAL\Driver\SavepointTrait;

class Driver extends AbstractDriver implements SavepointInterface
{
    use SavepointTrait;
}
