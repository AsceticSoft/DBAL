<?php

declare(strict_types=1);

namespace AsceticSoft\DBAL\PdoCommand;

use PDO;
use PDOStatement;

class ParamsBinder
{
    private iterable $params;

    public function __construct(iterable $params)
    {
        $this->params = $params;
    }

    public function __invoke(PDOStatement $statement): void
    {
        foreach ($this->params as $name => $value) {
            if ($value instanceof PdoValue) {
                $statement->bindValue($name, $value->getValue(), $value->getType());
            } else {
                $statement->bindValue($name, $value, $this->getPdoType($value));
            }
        }
    }

    public function __toString()
    {
        $result = [];
        foreach ($this->params as $name => $value) {
            if ($value instanceof PdoValue) {
                $result[] = ":$name=".$value->getValue();
            } else {
                $result[] = ":$name=".$value;
            }
        }

        return implode(',', $result);
    }

    protected function getPdoType($data)
    {
        static $typeMap = [
            // php type => PDO type
            'boolean' => PDO::PARAM_BOOL,
            'integer' => PDO::PARAM_INT,
            'string' => PDO::PARAM_STR,
            'resource' => PDO::PARAM_LOB,
            'NULL' => PDO::PARAM_NULL,
        ];
        $type = \gettype($data);

        return $typeMap[$type] ?? PDO::PARAM_STR;
    }
}
