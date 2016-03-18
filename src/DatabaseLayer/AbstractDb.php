<?php

namespace Masterclass\DatabaseLayer;

use PDO;

abstract class AbstractDb
{
    protected $pdo;

    public function __construct($dsn, $user, $pass)
    {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo = $pdo;
    }

    abstract public function fetchOne($sql, array $bind = []);

    abstract public function fetchAll($sql, array $bind = []);

    abstract public function execute($sql, array $bind = []);

    abstract public function rowCount($sql, array $bind = []);

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}