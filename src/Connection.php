<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL;

use AsceticSoft\DBAL\Driver\DriverFactory;
use AsceticSoft\DBAL\Driver\DriverInterface;
use AsceticSoft\DBAL\Event\ConnectionEvent;
use PDO;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use AsceticSoft\DBAL\PdoCommand\Statement;
use AsceticSoft\DBAL\PdoCommand\DbException;
use AsceticSoft\DBAL\PdoCommand\Fetch\Fetch;

class Connection implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private string $dsn;
    private ?string $username;
    private ?string $password;
    private array $options;
    private DriverInterface $driver;
    private ?Transaction $transaction = null;
    private ?PDO $pdo = null;
    private ?EventDispatcherInterface $eventDispatcher = null;
    /**
     * Connection constructor.
     *
     * @throws NotSupportedException
     */
    public function __construct(string $dsn, string $username = null, string $password = null, array $options = [])
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
        $this->driver = (new DriverFactory())($dsn);
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher): self
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    /**
     * Sets the isolation level of the current transaction.
     *
     * @see Transaction::READ_UNCOMMITTED
     * @see Transaction::READ_COMMITTED
     * @see Transaction::REPEATABLE_READ
     * @see Transaction::SERIALIZABLE
     * @see http://en.wikipedia.org/wiki/Isolation_%28database_systems%29#Isolation_levels
     */
    public function setTransactionIsolationLevel(string $isolationLevel): self
    {
        $this->driver->setTransactionIsolationLevel($this->getPdo(), $isolationLevel);

        return $this;
    }

    /**
     * Starts a transaction.
     *
     * @return Transaction the transaction initiated
     *
     * @throws NotSupportedException
     * @See Transaction::begin() for details.
     */
    public function beginTransaction(string $isolationLevel = null): Transaction
    {
        if (null === $this->transaction) {
            $this->transaction = new Transaction($this, $this->logger, $this->eventDispatcher);
        }

        return $this->transaction->begin($isolationLevel);
    }

    public function getDriver(): DriverInterface
    {
        return $this->driver;
    }

    public function getPdo(): PDO
    {
        if (null === $this->pdo) {
            $this->pdo = $this->driver->createPdoInstance(
                $this->dsn,
                $this->username,
                $this->password,
                $this->options
            );
            if ($this->eventDispatcher) {
                $this->eventDispatcher->dispatch(new ConnectionEvent($this, ConnectionEvent::EVENT_AFTER_OPEN));
            }
        }

        return $this->pdo;
    }

    public function isActive(): bool
    {
        return null !== $this->pdo;
    }

    /**
     * @throws DbException
     */
    public function execute(string $sql, iterable $params = []): int
    {
        return (new Statement($this->getPdo(), $sql))
            ->execute($params)
            ->rowCount();
    }

    /**
     * @throws DbException
     */
    public function fetch(string $sql, iterable $params = []): Fetch
    {
        return new Fetch((new Statement($this->getPdo(), $sql))->execute($params));
    }
}
