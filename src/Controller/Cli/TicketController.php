<?php
declare(strict_types=1);

namespace Alanpryoga\PhpTicket\Controller\Cli;

use Alanpryoga\PhpTicket\Service\TicketService;

class TicketController
{
    private TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function generateTickets(array $argv)
    {
        $eventId = (int) $argv[2];
        $n = (int) $argv[3];

        $hasErrors = false;
        if ($eventId == null || is_int($eventId) == false || $eventId == 0) {
            printf("\033[31mValidation failed, {event_id} must be number and mandatory.\033[0m\n");
            $hasErrors = true;
        }

        if ($n == null || is_int($n) == false || $n == 0) {
            printf("\033[31mValidation failed, {n} must be number and mandatory.\033[0m\n");
            $hasErrors = true;
        }

        if ($hasErrors) {
            return;
        }

        $ok = $this->ticketService->generateTickets($eventId, $n);
        if (! $ok) {
            printf("\033[31mFailed to generate tickets, event not found or internal server error.\033[0m\n");
            return;
        }

        printf("\033[32mSuccess to generate tickets.\033[0m\n");
        return;
    }
}