<?php

/**
 * php -S localhost:8080
 */

require_once '../../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../../Templates');
$twig = new Twig_Environment($loader, [
    'debug' => true
]);
$twig->addExtension(new Twig_Extension_Debug());

$template = $twig->load('Array/index.twig');

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

    $selectedMatches[] = $match;

}

echo $template->render([
    'matches' => $matches,
    'teams' => $teams,
    'selectedTeam' => $selectedTeam,
    'match' => $match,
    'selectedMatches' => $selectedMatches
]);
