<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\PdoCommand\Fetch;

use PDO;
use PDOStatement;

class BatchCursor implements \IteratorAggregate
{
    private PDOStatement $statement;
    private int $fetchStyle;
    private ?int $limit = null;
    private int $batchSize = 25;

    public function __construct(PDOStatement $statement, int $fetchStyle = PDO::FETCH_ASSOC)
    {
        $this->statement = $statement;
        $this->fetchStyle = $fetchStyle;
    }

    private function fetchNextBatch(): array
    {
        $key = 0;
        $batchRows = [];
        while (true) {
            $row = $this->statement->fetch($this->fetchStyle);
            if (false === $row) {
                $this->statement->closeCursor();
                break;
            }

            $batchRows[] = $row;

            ++$key;
            if ($this->limit && ($key >= $this->limit)) {
                $this->statement->closeCursor();
                break;
            }

            if ($key >= $this->batchSize) {
                break;
            }
        }

        return $batchRows;
    }

    public function getIterator(): iterable
    {
        while (true) {
            $batchRows = $this->fetchNextBatch();
            if (empty($batchRows)) {
                break;
            }
            yield $batchRows;
        }
    }

    public function setBatchSize(int $batchSize): self
    {
        $this->batchSize = $batchSize;

        return $this;
    }

    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }
}
