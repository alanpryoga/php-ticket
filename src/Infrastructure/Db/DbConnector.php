<?php
declare(strict_types=1);

namespace Alanpryoga\PhpTicket\Infrastructure\Db;

interface DbConnector
{
    public function getConnection() : \PDO;
}
