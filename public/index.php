<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$app = new \Alanpryoga\PhpTicket\App\RestApp();

$dbConfig = require __DIR__ . '/../config/db.php';
$app->setdbConfig($dbConfig);

$app->run();
