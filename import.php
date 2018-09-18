<?php

use Model\Database;
use Model\Match;

require_once 'Model/Database.php';
require_once 'Model/Match.php';
require_once 'Model/Result.php';
require_once 'Model/Team.php';

$content = file_get_contents('https://www.openligadb.de/api/getmatchdata/bl3/2018');
$matches = json_decode($content, true);

$database = new Database();

function convertDate(string $date): string
{
    return date('Y-m-d H:i:s', strtotime($date));
}
$database->truncate('matches');
foreach ($matches as $match) {
    $row = [
        'match_Id' => $match['MatchID'],
        'team1_Id' => $match['Team1']['TeamId'],
        'team2_Id' => $match['Team2']['TeamId'],
        'is_finished' => null,
        'team1_goals' => null,
        'team2_goals' => null,
        'team1_half_time_goals' => null,
        'team2_half_time_goals' => null,

        'date' => convertDate($match['MatchDateTimeUTC']),
    ];

    if (!empty($match['MatchIsFinished'])){
        $row['is_finished'] = $match['MatchIsFinished'];
    } else {
        $row['is_finished'] = null;
    }

    if (!empty($match['MatchResults'][0])) {
        $row['team1_half_time_goals'] = $match['MatchResults'][0]['PointsTeam1'];
        $row['team2_half_time_goals'] = $match['MatchResults'][0]['PointsTeam2'];
    }

    if (!empty($match['MatchResults'][1])) {
        $row['team1_goals'] = $match['MatchResults'][1]['PointsTeam1'];
        $row['team2_goals'] = $match['MatchResults'][1]['PointsTeam2'];
    }

    $database->insert('matches', $row);
}

$database->truncate('teams');
foreach ($matches as $match) {
    $row =[
        'team_Id' => $match['Team1']['TeamId'],
        'team_icon_url' => $match['Team1']['TeamIconUrl'],
        'team_name' => $match['Team1']['TeamName']
    ];

    try {
        $database->insert('teams', $row);
    } catch (Exception $e) {
//        var_dump(get_class($e));
//        die();
        continue;
    }
}

//var_dump($dbMatches[36]); die();




//var_dump($dbMatches);
// array2 deklarieren $matches = []
// foreach $dbMatches
    // neue instanz der klasse Match $match = new Match()
    // Die Instanz füllen mit dem Array $match->setDateTime($dbMatches['daytime])
    // die instanz in array2 schreiben $matches[] = $match


