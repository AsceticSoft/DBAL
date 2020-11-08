<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\PdoCommand;

use PDO;
use PDOException;
use PDOStatement;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class Statement implements StatementInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private PDO $pdo;
    private string $sql;
    private array $options;
    private ?PDOStatement $statement = null;

    public function __construct(PDO $pdo, string $sql, array $options = [])
    {
        $this->pdo = $pdo;
        $this->sql = $sql;
        $this->options = $options;
    }

    /**
     * @throws DbException
     */
    public function prepare(iterable $params = []): PDOStatement
    {
        if ($this->statement) {
            return $this->statement;
        }
        try {
            $statement = $this->pdo->prepare($this->sql, $this->options);
            if (false === $statement) {
                throw new DbException("Failed to prepare SQL: $this->sql");
            }
            $bindParams = new ParamsBinder($params);
            $bindParams($statement);
            $this->logger && $this->logger->debug('Statement prepared');

            return $this->statement = $statement;
        } catch (PDOException $e) {
            $message = $e->getMessage()."\nFailed to prepare SQL: ".$this->dumpParams($this->statement, $this->sql);
            throw new DbException($message, $e->errorInfo, (int) $e->getCode(), $e);
        }
    }

    /**
     * @throws DbException
     */
    public function execute(iterable $params = []): PDOStatement
    {
        $statement = $this->prepare();
        try {
            $bindParams = new ParamsBinder($params);
            $bindParams($statement);
            if (!$statement->execute()) {
                throw new DbException("Failed to execute SQL: $this->sql");
            }
            $this->logger && $this->logger->debug('Statement executed');

            return $statement;
        } catch (PDOException $e) {
            $message = $e->getMessage()."\nFailed to execute SQL: ".$this->dumpParams($statement, $this->sql);
            throw new DbException($message, $e->errorInfo, (int) $e->getCode(), $e);
        }
    }

    protected function dumpParams(?PDOStatement $statement, string $sql)
    {
        if (null === $statement) {
            return $sql;
        }
        ob_start();
        $statement->debugDumpParams();
        $params = ob_get_contents();
        ob_end_clean();

        return $params;
    }
}
