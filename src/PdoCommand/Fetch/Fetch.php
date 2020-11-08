<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\PdoCommand\Fetch;

class Fetch
{
    private int $fetchStyle = \PDO::FETCH_ASSOC;
    private \PDOStatement $statement;

    public function __construct(\PDOStatement $statement)
    {
        $this->statement = $statement;
    }

    public function one(): array
    {
        $result = $this->statement->fetch($this->fetchStyle);
        $this->statement->closeCursor();

        return \is_array($result) ? $result : [];
    }

    public function all(): array
    {
        $result = $this->statement->fetchAll($this->fetchStyle);
        $this->statement->closeCursor();

        return \is_array($result) ? $result : [];
    }

    public function column(int $columnNumber = 0): array
    {
        $result = $this->statement->fetchAll(\PDO::FETCH_COLUMN, $columnNumber);

        return \is_array($result) ? $result : [];
    }

    /**
     * Executes the SQL statement and returns the value of the first column in the first row of data.
     * This method is best used when only a single value is needed for a query.
     *
     * @return string|false|null the value of the first column in the first row of the query result.
     *                           False is returned if there is no value.
     */
    public function scalar(int $columnNumber = 0)
    {
        $result = $this->statement->fetchColumn($columnNumber);
        if (\is_resource($result) && 'stream' === get_resource_type($result)) {
            return stream_get_contents($result);
        }
        $this->statement->closeCursor();

        return $result;
    }

    public function exists(): bool
    {
        return (bool) $this->scalar(0);
    }

    /**
     * Fetch a two-column result into an array where the first column is a key and the second column is the value.
     */
    public function map(): array
    {
        $result = $this->statement->fetchAll(\PDO::FETCH_KEY_PAIR);

        return \is_array($result) ? $result : [];
    }

    /**
     * Fetch rows indexed by first column.
     *
     * @see PDO::FETCH_UNIQUE
     */
    public function indexed(): array
    {
        $result = $this->statement->fetchAll(\PDO::FETCH_UNIQUE);

        return \is_array($result) ? $result : [];
    }

    /**
     * Fetch rows grouped by first column values.
     *
     * @see PDO::FETCH_GROUP
     */
    public function grouped(): array
    {
        $result = $this->statement->fetchAll(\PDO::FETCH_GROUP);

        return \is_array($result) ? $result : [];
    }

    /**
     * Iterates over database cursor.
     */
    public function cursor(?int $limit = null): \Traversable
    {
        return (new Cursor($this->statement, $this->fetchStyle))
            ->setLimit($limit);
    }

    /**
     * Returns iterable batch array of rows.
     */
    public function batchCursor(int $batchSize = 25, ?int $limit = null): \Traversable
    {
        return (new BatchCursor($this->statement, $this->fetchStyle))
            ->setBatchSize($batchSize)
            ->setLimit($limit);
    }
}
