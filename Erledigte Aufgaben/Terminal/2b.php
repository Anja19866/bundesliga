<?php

$content = file_get_contents('https://www.openligadb.de/api/getmatchdata/bl3/2018');
$matches = json_decode($content, true);

foreach ($matches as $match) {
    if ($match['Team1']['TeamId'] == 105 || $match['Team2']['TeamId'] == 105) {
        echo "------------------------------------------------------------------------------------\n";
        echo str_pad($match['Team1']['TeamName'], 25) . " : " .
            str_pad($match['Team2']['TeamName'], 25) . "|";
        if ($match['MatchIsFinished'] == true) {
            echo str_pad($match['MatchResults'][1]['PointsTeam1'] . ":" . $match['MatchResults'][1]['PointsTeam2'] . " (" .
                $match['MatchResults'][0]['PointsTeam1'] . ":" . $match['MatchResults'][0]['PointsTeam2'] . ") ", 20," ", STR_PAD_LEFT) . "| " .
                str_pad(date('H:i', strtotime($match['MatchDateTimeUTC'])) . " Uhr", 25) . " |\n";
        } else {
            echo str_pad(date('d.m.Y H:i', strtotime($match['MatchDateTimeUTC'])) . " Uhr", 25," ", STR_PAD_LEFT) . " |\n";
        }
    }
}