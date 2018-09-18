<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

$rows = [
    [
        'name' => 'Jochen',
        'groesse' => '3m',
    ],
    [
        'name' => 'Amos',
        'groesse' => '1m',
    ],
];
var_dump($rows);
$table = new Table(new ConsoleOutput());
$table->setHeaders(['Name', 'Groesse']);
$table->setRows($rows);
$table->render();
