<?php
declare(strict_types=1);

namespace Alanpryoga\PhpTicket\Repository\Db;

use Alanpryoga\PhpTicket\Infrastructure\Db\DbConnector;

class EventRepository
{
    private $dbConn;

    public function __construct(DbConnector $dbConn)
    {
        $this->dbConn = $dbConn->getConnection();
    }

    public function getEventById(int $id) : array
    {
        $query = 'SELECT id, name FROM events WHERE id=? LIMIT 1';

        $stmt = $this->dbConn->prepare($query);
        $stmt->execute([$id]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $stmt = null;

        if (! $result) {
            return [];
        }
        return $result;
    }
}