<?php
declare(strict_types=1);

namespace Alanpryoga\PhpTicket\App;

use Alanpryoga\PhpTicket\Controller\Rest\TicketController;
use Alanpryoga\PhpTicket\Infrastructure\Db\MySqlConnector;
use Alanpryoga\PhpTicket\Repository\Db\TicketRepository;
use Alanpryoga\PhpTicket\Service\TicketService;

class RestApp
{
    private array $dbConfig;

    public function setdbConfig(array $dbConfig)
    {
        $this->dbConfig = $dbConfig;
    }

    public function run() : void
    {
        $mysqlDbConn = new MySqlConnector(
            $this->dbConfig['hostname'], 
            $this->dbConfig['username'], 
            $this->dbConfig['password'], 
            $this->dbConfig['database'], 
            $this->dbConfig['port']
        );

        $ticketDbRepo = new TicketRepository($mysqlDbConn);
        $ticketService = new TicketService($ticketDbRepo);
        $ticketController = new TicketController($ticketService);

        $request = $_SERVER['REQUEST_URI'];
        switch ($request) {
            case '/':
                echo 'Hello world!';
                break;
            case '':
                echo 'Hello world!';
                break;
            case '/ticket/check':
                $ticketController->checkTicketStatus($_GET);
                break;
            case '/ticket/update':
                $ticketController->updateTicketStatus($_POST);
                break;
            default:
                http_response_code(404);
                echo 'The page you are looking for could not be found.';
                break;
        }
    }
}
