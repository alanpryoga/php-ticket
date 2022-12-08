<?php
declare(strict_types=1);

namespace Alanpryoga\PhpTicket\App;

use Alanpryoga\PhpTicket\Controller\Cli\TicketController;
use Alanpryoga\PhpTicket\Infrastructure\Db\MySqlConnector;
use Alanpryoga\PhpTicket\Repository\Db\EventRepository;
use Alanpryoga\PhpTicket\Repository\Db\TicketRepository;
use Alanpryoga\PhpTicket\Service\TicketService;

class CliApp
{
    private array $dbConfig;

    public function setdbConfig(array $dbConfig)
    {
        $this->dbConfig = $dbConfig;
    }

    public function run(array $argv) : void
    {
        $mysqlDbConn = new MySqlConnector(
            $this->dbConfig['hostname'], 
            $this->dbConfig['username'], 
            $this->dbConfig['password'], 
            $this->dbConfig['database'], 
            $this->dbConfig['port']
        );

        $eventDbRepo = new EventRepository($mysqlDbConn);

        $ticketDbRepo = new TicketRepository($mysqlDbConn);
        $ticketService = new TicketService($eventDbRepo, $ticketDbRepo);
        $ticketController = new TicketController($ticketService);

        if (isset($argv[1])) {
            if ($argv[1] == 'generate-ticket') {
                if (! isset($argv[2]) || ! isset($argv[3])) {
                    printf("\033[36mphp app generate-ticket {event_id} {n}\033[0m\n");
                    printf("  {event_id}  : number and mandatory.\n");
                    printf("  {n}         : number and mandatory.\n");
                    return;
                }

                $ticketController->generateTickets($argv);
                return;
            }
        }

        printf("Available commands: \n");
        printf("\033[36m  php app generate-ticket {event_id} {n}\033[0m\n");
        printf("    {event_id}  : number and mandatory.\n");
        printf("    {n}         : number and mandatory.\n");
    }
}
