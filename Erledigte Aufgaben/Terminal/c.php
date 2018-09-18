<?php

//$array = [];
//print_r($array);
//
//$array['key'] = 'value';
//$array['neuer_key'] = 'neues value';
//print_r($array);
//
//$array['key'] = 'asdasdadasd';
//print_r($array);
//die();


require_once 'vendor/autoload.php';

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

$content = file_get_contents('https://www.openligadb.de/api/getmatchdata/bl3/2018');
$matches = json_decode($content, true);

$teams = [];
foreach ($matches as $match) {
    $teamId = $match['Team1']['TeamId'];
    $teamName = $match['Team1']['TeamName'];
    $teams[] = $teamName;
}
$teams = array_unique($teams);

sort($teams);

foreach ($teams as $i => $team) {
    echo ++$i . '. ' . $team . "\n";
}

$teamNumber = readline('Eingabe: ') - 1;
$selectedTeamName = $teams[$teamNumber];

$rows = [];
foreach ($matches as $match) {
    if ($match['Team1']['TeamName'] === $selectedTeamName || $match['Team2']['TeamName'] === $selectedTeamName) {
        $row = [
            'team1_name' => $match['Team1']['TeamName'],
            'team2_name' => $match['Team2']['TeamName'],
            'result' => '',
            'time' => date('H:i', strtotime($match['MatchDateTimeUTC'])) . " Uhr",
            'date' => date('d.m.Y', strtotime($match['MatchDateTimeUTC']))
        ];

        if (isset($match['MatchResults'][1]['PointsTeam1'])) {
            $row['result'] = $match['MatchResults'][1]['PointsTeam1'] . ':' . $match['MatchResults'][1]['PointsTeam2'];
            $row['result'] .= ' ';
            $row['result'] .= '(' . $match['MatchResults'][0]['PointsTeam1'] . ':' . $match['MatchResults'][0]['PointsTeam2'] . ')';
        }

        $rows[] = $row;
    }
}

$table = new Table(new ConsoleOutput());
$table->setHeaders(['Team1', 'Team2', 'Ergebnis', 'Uhrzeit', 'Datum']);
$table->addRows($rows);
$table->render();

//
//   print_r($matches);
//    die();
