<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\PdoCommand\Fetch;

use PDO;
use PDOStatement;

class Cursor implements \IteratorAggregate
{
    private PDOStatement $statement;
    private ?int $limit = null;
    private int $fetchStyle;

    public function __construct(PDOStatement $statement, int $fetchStyle = PDO::FETCH_ASSOC)
    {
        $this->statement = $statement;
        $this->fetchStyle = $fetchStyle;
    }

    public function getIterator(): \Traversable
    {
        $key = 0;
        while (true) {
            if ($this->limit && ($key >= $this->limit)) {
                break;
            }
            $row = $this->statement->fetch($this->fetchStyle);
            if (false === $row) {
                break;
            }
            ++$key;

            yield $row;
        }
        $this->statement->closeCursor();
    }

    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }
}
