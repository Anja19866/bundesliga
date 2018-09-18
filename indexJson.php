<?php

/**
 * php -S localhost:8080
 */

require_once 'vendor/autoload.php';
require_once 'Model/Match.php';
require_once 'Model/Team.php';
require_once 'Model/Result.php';

use Model\Match;
use Model\Team;
use Model\Result;

$loader = new Twig_Loader_Filesystem('Templates');
$twig = new Twig_Environment($loader, [
    'debug' => true
]);
$twig->addExtension(new Twig_Extension_Debug());

$template = $twig->load('index.twig');

$content = file_get_contents('https://www.openligadb.de/api/getmatchdata/bl3/2018');
$matches = json_decode($content, true);

// Teams als Objekte speichern
// über die Matches iterieren und Team-Objekte erstellen
/** @var Team[] $teams */
$teams = [];
foreach ($matches as $match) {
    $team = new Team();
    $team->setId($match['Team1']['TeamId'])
        ->setName($match['Team1']['TeamName'])
        ->setIcon($match['Team1']['TeamIconUrl']);

    $teams[$team->getId()] = $team;
}

// Teams sortieren
uasort($teams, function (Team $teamA, Team $teamB) {
    return strcmp($teamA->getName(), $teamB->getName());
});

// Selektiertes Team speichern
/** @var Team $selectedTeam */
if (!empty($_GET['id']) && !empty($teams[$_GET['id']])) {
    $selectedTeam = $teams[$_GET['id']];
} else {
    // wenn noch kein Team selektiert wurde, dann nehme das Standard-Team
    $selectedTeam = $teams[105];
}

$selectedMatches = [];
foreach ($matches as $match) {
    // Match als Objekt speichern
    $matchModel = new Match();
    $matchModel
        ->setTeam1($teams[$match['Team1']['TeamId']])
        ->setTeam2($teams[$match['Team2']['TeamId']])
//        ->setMatchIsFinished($match['MatchIsFinished'])
        ->setMatchDateTime(new DateTime($match['MatchDateTime']));

    // nur Spiele von dem selektierten Team speichern
    if (
        $matchModel->getTeam1()->getName() !== $selectedTeam->getName() &&
        $matchModel->getTeam2()->getName() !== $selectedTeam->getName()
    ) {
        continue;
    }

    // Ergebnisse speichern
    foreach ($match['MatchResults'] as $resultData) {
        $result = new Result();
        $result
            ->setPointsTeam1($resultData['PointsTeam1'])
            ->setPointsTeam2($resultData['PointsTeam2']);

        if ($resultData['ResultName'] === 'Halbzeitstand') {
            $matchModel->setHalfTimeResult($result);
        } elseif ($resultData['ResultName'] === 'Endergebnis') {
            $matchModel->setEndResult($result);
        }
    }

    $selectedMatches[] = $matchModel;
}

// Objekte an die Ansicht übergeben
echo $template->render([
    'teams' => $teams,
    'selectedTeam' => $selectedTeam,
    'selectedMatches' => $selectedMatches
]);
