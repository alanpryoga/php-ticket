<?php
declare(strict_types=1);

namespace Alanpryoga\PhpTicket\Controller\Rest;

use Alanpryoga\PhpTicket\Service\TicketService;

class TicketController
{
    private TicketService $ticketService;

    private const TICKET_POSSIBLESTATUS = ['available', 'claimed'];

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function checkTicketStatus(array $args) : void
    {
        header('Content-Type: application/json; charset=utf-8');

        $eventId = isset($args['event_id']) ? (int) $args['event_id'] : 0;
        $code = isset($args['code']) ? (string) $args['code'] : '';

        $errors = [];
        if ($eventId == null || is_int($eventId) == false || $eventId == 0) {
            $errors[] = [
                'event_id' => 'Field event_id must be number and mandatory.'
            ];
        }

        if ($code == null || is_string($code) == false || $code == '') {
            $errors[] = [
                'code' => 'Field code must be alphanum and mandatory.'
            ];
        }

        if (count($errors) > 0) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $errors
            ]);
            return;
        }

        $ticket = $this->ticketService->checkTicketStatus($eventId, $code);
        if (count($ticket) == 0) {
            http_response_code(404);
            echo json_encode([
                'status' => 'error',
                'message' => 'Ticket not found.'
            ]);
            return;
        }

        http_response_code(200);
        echo json_encode([
            'status' => 'ok',
            'message' => 'Success to fetch ticket.',
            'data' => $ticket
        ]);
        return;
    }

    public function updateTicketStatus(array $args) : void
    {
        header('Content-Type: application/json; charset=utf-8');

        $eventId = isset($args['event_id']) ? (int) $args['event_id'] : 0;
        $code = isset($args['code']) ? (string) $args['code'] : '';
        $status = isset($args['status']) ? (string) $args['status'] : '';

        $errors = [];
        if ($eventId == null || is_int($eventId) == false || $eventId == 0) {
            $errors[] = [
                'event_id' => 'Field event_id must be number and mandatory.'
            ];
        }

        if ($code == null || is_string($code) == false || $code == "") {
            $errors[] = [
                'code' => 'Field code must be alphanum and mandatory.'
            ];
        }

        if ($status == null || is_string($status) == false || $status == "" || in_array($status, self::TICKET_POSSIBLESTATUS) == false) {
            $errors[] = [
                'status' => 'Field status must be has value available or claimed, alphanum, and mandatory.'
            ];
        }

        if (count($errors) > 0) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Validation failed.',
                'errors' => $errors
            ]);
            return;
        }

        $ticket = $this->ticketService->updateTicketStatus($eventId, $code, $status);
        if (count($ticket) == 0) {
            http_response_code(404);
            echo json_encode([
                'status' => 'error',
                'message' => 'Ticket not found.'
            ]);
            return;
        }

        http_response_code(200);
        echo json_encode([
            'status' => 'ok',
            'message' => 'Success to update ticket.',
            'data' => $ticket
        ]);
        return;
    }
}
