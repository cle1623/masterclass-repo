<?php

namespace Masterclass\DatabaseLayer;

use PDO;

use Masterclass\DatabaseLayer\AbstractDb;

class Mysql extends AbstractDb
{
    /**
     * @var \PDOStatement
     */
    protected $statement;

    public function fetchOne($sql, array $bind = [])
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($bind);
        return $statement->fetch();
    }

    public function fetchAll($sql, array $bind = [])
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($bind);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute($sql, array $bind = [])
    {
        $statement = $this->pdo->prepare($sql);
        return $statement->execute($bind);
    }

    public function rowCount($sql, array $bind = [])
    {
        $statement = $this->pdo->prepare($sql);
        $statement->execute($bind);
        return $statement->rowCount();
    }

}