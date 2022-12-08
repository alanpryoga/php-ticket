#!/usr/bin/env php
<?php
declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

$app = new \Alanpryoga\PhpTicket\App\CliApp();

$dbConfig = require __DIR__ . '/config/db.php';
$app->setdbConfig($dbConfig);

$app->run($argv);
