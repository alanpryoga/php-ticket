<?php
declare(strict_types=1);

namespace Alanpryoga\PhpTicket\Repository\Db;

use Alanpryoga\PhpTicket\Infrastructure\Db\DbConnector;

class TicketRepository
{
    private $dbConn;

    public function __construct(DbConnector $dbConn)
    {
        $this->dbConn = $dbConn->getConnection();
    }

    public function insertBulkTickets(array $tickets) : bool
    {
        $query = 'INSERT INTO tickets (event_id, code, status) VALUES (?, ?, ?)';

        $stmt = $this->dbConn->prepare($query);

        $this->dbConn->beginTransaction();
        foreach ($tickets as $ticket) {
            try {
                $stmt->execute([$ticket['event_id'], $ticket['code'], $ticket['status']]);
            } catch (\PDOException){
                $this->dbConn->rollBack();
                return false;
            }
        }
        $this->dbConn->commit();

        return true;
    }

    public function getTicketByEventIdAndCode(int $eventId, string $code) : array
    {
        $query = 'SELECT id, event_id, code, status, created_at, updated_at FROM tickets WHERE event_id=? AND code=? LIMIT 1';

        $stmt = $this->dbConn->prepare($query);
        $stmt->execute([$eventId, $code]);

        $result = $stmt->fetch();
        $stmt = null;

        if (! $result) {
            return [];
        }
        return $result;
    }

    public function updateTicketStatusByEventIdAndCode(int $eventId, string $code, string $status) : bool
    {
        $query = 'UPDATE tickets SET status=? WHERE event_id=? AND code=?';

        $stmt = $this->dbConn->prepare($query);
        $stmt->execute([$status, $eventId, $code]);

        $rowCount = $stmt->rowCount();
        $stmt = null;

        if ($rowCount == 0) {
            return false;
        }
        return true;
    }
}
