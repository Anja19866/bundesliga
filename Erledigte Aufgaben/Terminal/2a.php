<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

$content = file_get_contents('https://www.openligadb.de/api/getmatchdata/bl3/2018/1');
$matches = json_decode($content, true);

foreach ($matches as $match) {
    $rows[] = [
        'team1_name' => $match['Team1']['TeamName'],
        'team2_name' => $match['Team2']['TeamName'],
        'results' => $match['MatchResults'][1]['PointsTeam1'] . ":" .
                    $match['MatchResults'][1]['PointsTeam2'] . " (" .
                    $match['MatchResults'][0]['PointsTeam1'] . ":" .
                    $match['MatchResults'][0]['PointsTeam2'] . ") ",
        'time' => date('H:i', strtotime($match['MatchDateTimeUTC'])) . " Uhr\n"];
}

$table = new Table(new ConsoleOutput());
$table->setHeaders(['Team 1', 'Team 2', 'Results', 'Time']);
$table->setRows($rows);
$table->render();