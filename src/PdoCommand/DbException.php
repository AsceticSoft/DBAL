<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\PdoCommand;

use AsceticSoft\DBAL\Exception;

class DbException extends Exception
{
    /**
     * the error info provided by a PDO exception. This is the same as returned
     * by [PDO::errorInfo](http://www.php.net/manual/en/pdo.errorinfo.php).
     */
    public ?array $errorInfo = null;

    /**
     * Constructor.
     *
     * @param string $message PDO error message
     * @param array $errorInfo PDO error info
     * @param int $code PDO error code
     * @param \Exception|null $previous the previous exception used for the exception chaining
     */
    public function __construct(string $message, ?array $errorInfo = null, int $code = 0, \Exception $previous = null)
    {
        $this->errorInfo = $errorInfo;
        parent::__construct($message, $code, $previous);
    }

    /**
     * the user-friendly name of this exception
     */
    public function getName(): string
    {
        return 'Database Exception';
    }

    /**
     * @return string readable representation of exception
     */
    public function __toString()
    {
        return parent::__toString().PHP_EOL
            .'PDO Error info:'.PHP_EOL.print_r($this->errorInfo, true);
    }
}
