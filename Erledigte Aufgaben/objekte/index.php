<?php

/**
 * php -S localhost:8080
 */

require_once '../../vendor/autoload.php';
require_once 'Model/Match.php';

use Model\Match;

$loader = new Twig_Loader_Filesystem('Templates');
$twig = new Twig_Environment($loader, [
    'debug' => true
]);
$twig->addExtension(new Twig_Extension_Debug());

$template = $twig->load('index.twig');

$content = file_get_contents('https://www.openligadb.de/api/getmatchdata/bl3/2018');
$matches = json_decode($content, true);

$teams = [];
foreach ($matches as $match) {
    $teamId = $match['Team1']['TeamId'];
    $teams[$teamId] = $match['Team1'];
}

uasort($teams, function ($teamA, $teamB) {
    return strcmp($teamA['TeamName'], $teamB['TeamName']);
});

if (!empty($_GET['id']) && !empty($teams[$_GET['id']])) {
    $selectedTeam = $teams[$_GET['id']];
} else {
    $selectedTeam = $teams[105];
}

$selectedMatches = [];
foreach ($matches as $match) {
    if (
        $match['Team1']['TeamName'] !== $selectedTeam['TeamName'] &&
        $match['Team2']['TeamName'] !== $selectedTeam['TeamName']
    ) {
        continue;
    }

    $matchModel = new Match();
    $matchModel->setTeam1($match['Team1']['TeamName'])
        ->setTeam2($match['Team2']['TeamName'])
        ->setteam1Icon($match['Team1']['TeamIconUrl'])
        ->setteam2Icon($match['Team2']['TeamIconUrl'])
        ->setMatchIsFinished($match['MatchIsFinished'])
        ->setMatchDateTime($match['MatchDateTime']);

    foreach ($match['MatchResults'] as $result) {
        if ($result['ResultName'] === 'Halbzeitstand') {
            $matchModel
                ->setResultTeam1Half1($result['PointsTeam1'] != 0 ?: 0)
                ->setResultTeam2Half1($result['PointsTeam2'] != 0 ?: 0);

        } elseif ($result['ResultName'] === 'Endergebnis') {
            $matchModel
                ->setResultTeam1End($result['PointsTeam1'] != 0 ?: 0)
                ->setResultTeam2End($result['PointsTeam2'] != 0 ?: 0);
        }
    }

    $selectedMatches[] = $matchModel;
}

echo $template->render([
    'teams' => $teams,
    'selectedTeam' => $selectedTeam,
    'selectedMatches' => $selectedMatches
]);
