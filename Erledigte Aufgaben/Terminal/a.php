<?php

// var_dump im HTML
// print_r auf der Console

// date('H:i', strtotime($match['MatchDateTimeUTC']))

$content = file_get_contents('https://www.openligadb.de/api/getmatchdata/bl3/2018/1');

$matches = json_decode($content, true);

foreach ($matches as $match) {
    echo $match['Team1']['TeamName'] . " : "
        . $match['Team2']['TeamName'] . " | "
        . $match ['MatchResults'][1]['PointsTeam1']
        . ":" . $match['MatchResults'][1]['PointsTeam2'] . " ("
        . $match ['MatchResults'][0]['PointsTeam1']
        . ":" . $match['MatchResults'][0]['PointsTeam2'] . ") | "
        . date('H:i', strtotime($match['MatchDateTimeUTC'])) . " Uhr \n";
//    print_r($match);
//    die();
}