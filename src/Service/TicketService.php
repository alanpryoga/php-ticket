<?php
declare(strict_types=1);

namespace Alanpryoga\PhpTicket\Service;

use Alanpryoga\PhpTicket\Repository\Db\TicketRepository;

class TicketService
{
    private TicketRepository $ticketDbRepo;

    private const TICKET_DEFAULTSTATUS = 'available';

    private const TICKETCODE_PREFIX = 'DTK';

    private const TICKETCODE_RANDOMALPHANUMLEN = 7;

    public function __construct(TicketRepository $ticketDbRepo)
    {
        $this->ticketDbRepo = $ticketDbRepo;
    }

    private function generateTicketCode(string $prefix, int $randomAlphaNumLen = 7) : string
    {
        $bytes = random_bytes($randomAlphaNumLen);
        return $prefix . strtoupper(bin2hex($bytes));
    }

    public function generateTickets(int $eventId, int $num) : bool
    {
        $tickets = [];
        for ($i=0; $i < $num; $i++) { 
            $ticketCode = '';
            while (true) {
                $ticketCode = $this->generateTicketCode(self::TICKETCODE_PREFIX, self::TICKETCODE_RANDOMALPHANUMLEN);
                if (array_search($ticketCode, array_column($tickets, 'code')) == false) {
                    break;
                }
            }

            $tickets[] = [
                'event_id' => $eventId,
                'code' => $ticketCode,
                'status' => self::TICKET_DEFAULTSTATUS
            ];
        }

        $ok = $this->ticketDbRepo->insertBulkTickets($tickets);
        if (! $ok) {
            return false;
        }

        return true;
    }

    public function checkTicketStatus(int $eventId, string $code) : array
    {
        $ticket = $this->ticketDbRepo->getTicketByEventIdAndCode($eventId, $code);
        if (count($ticket) == 0) {
            return [];
        }

        return $ticket;
    }

    public function updateTicketStatus(int $eventId, string $code, string $status) : array
    {
        $ok = $this->ticketDbRepo->updateTicketStatusByEventIdAndCode($eventId, $code, $status);
        if (! $ok) {
            return [];
        }

        return $this->checkTicketStatus($eventId, $code);
    }
}
