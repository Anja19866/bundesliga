<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;


$content = file_get_contents('https://www.openligadb.de/api/getmatchdata/bl3/2018/1');
$matches = json_decode($content, true);

$table = new Table(new ConsoleOutput());
$table->setHeaders(['Team1', 'Team2', 'Results', 'Time']);

$rows = [];

foreach ($matches as $match) {
    $rows[] = [
        $match['Team1']['TeamName'],
        $match['Team2']['TeamName'],
        $match ['MatchResults'][1]['PointsTeam1']. ":" .
        $match['MatchResults'][1]['PointsTeam2'] . " (" .
        $match ['MatchResults'][0]['PointsTeam1']. ":" .
        $match['MatchResults'][0]['PointsTeam2'] . ")",
        date('H:i', strtotime($match['MatchDateTimeUTC'])) . " Uhr \n",
    ];
}


$table->setRows($rows);
$table->render();