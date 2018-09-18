<?php

/**
 * php -S localhost:8080
 */

require_once 'vendor/autoload.php';
require_once 'Model/Match.php';
require_once 'Model/Team.php';
require_once 'Model/Result.php';
require_once 'Model/Database.php';


use Model\Match;
use Model\Team;
use Model\Result;
use Model\Database;

$loader = new Twig_Loader_Filesystem('Templates');
$twig = new Twig_Environment($loader, [
    'debug' => true
]);
$twig->addExtension(new Twig_Extension_Debug());

$template = $twig->load('index.twig');

//für Daten aus Datenbank
$database = new Database();

$dbTeams = $database->getRows('SELECT * FROM teams');
$teams = [];
foreach ($dbTeams as $dbTeam) {
    $team = new Model\Team();
    $team->setId($dbTeam['team_Id']);
    $team->setIcon($dbTeam['team_icon_url']);
    $team->setName($dbTeam['team_name']);
    $teams[$team->getId()] = $team;
}


// Teams sortieren
uasort($teams, function (Team $teamA, Team $teamB) {
    return strcmp($teamA->getName(), $teamB->getName());
});
//
//// Selektiertes Team speichern
///** @var Team $selectedTeam */
if (!empty($_GET['id']) && !empty($teams[$_GET['id']])) {
    $selectedTeam = $teams[$_GET['id']];
} else {
    // wenn noch kein Team selektiert wurde, dann nehme das Standard-Team
    $selectedTeam = $teams[105];
}

$dbMatches = $database->getRows('SELECT * FROM matches ORDER BY date');
//echo"<pre>";
//var_dump($dbMatches); die();
$selectedMatches = [];
foreach ($dbMatches as $dbMatch) {
    $endResult = new Result();
    $endResult->setPointsTeam1($dbMatch['team1_goals']);
    $endResult->setPointsTeam2($dbMatch['team2_goals']);

    $halfResult = new Result();
    $halfResult->setPointsTeam1($dbMatch['team1_half_time_goals']);
    $halfResult->setPointsTeam2($dbMatch['team2_half_time_goals']);

    $match = new Match();
    $match->setId($dbMatch['match_Id']);

    /**
     * $matchDate = new DateTime($dbMatch['date'])
     * $now = new DateTime('now')
     *
     * Möglichkeit 1: Shorthand if else
     * $match->setMatchIsFinished( ($matchDate < $now) ? true : false);
     *
     * Möglichkeit 2: Dasselbe nur länger
     * $isFinished = false;
     * if ($matchDate < $now) {
     *   $isFinished = true;
     * }
     * $match->setMatchIsFinished($isFinished);
     *
     * Möglichkeit 3:
     * if ($matchDate < $now) {
     *   $isFinished = true;
     * } else {
     *  $isFinished = false;
     * }
     * $match->setMatchIsFinished($isFinished);
     *
     * Möglichkeit 4:
     * if ($matchDate < $now) {
     *   $match->setMatchIsFinished(true);
     * } else {
     *  $match->setMatchIsFinished(false);
     * }
     */
    $matchDate = new DateTime($dbMatch['date']);
    $now = new DateTime('now');

    $match->setMatchIsFinished(($matchDate < $now) ? true : false);
    $match->setEndResult($endResult);
    $match->setHalfTimeResult($halfResult);
    $match->setMatchDateTime(new DateTime($dbMatch['date']));

    $team1 = $teams[$dbMatch['team1_Id']];
    $match->setTeam1($team1);
    $team2 = $teams[$dbMatch['team2_Id']];
    $match->setTeam2($team2);

    if ($selectedTeam !== $team1 && $selectedTeam !== $team2) {

        continue;
    }
    $selectedMatches[] = $match;
}

//$selectedMatches = [];
//foreach ($matches as $match) {
//    // Match als Objekt speichern
//    $matchModel = new Match();
//    $matchModel
//        ->setTeam1($teams[$match['Team1']['TeamId']])
//        ->setTeam2($teams[$match['Team2']['TeamId']])
//        ->setMatchIsFinished($match['MatchIsFinished'])
//        ->setMatchDateTime(new DateTime($match['MatchDateTime']));
//
//    // nur Spiele von dem selektierten Team speichern
//    if (
//        $matchModel->getTeam1()->getName() !== $selectedTeam->getName() &&
//        $matchModel->getTeam2()->getName() !== $selectedTeam->getName()
//    ) {
//        continue;
//    }
//
//    // Ergebnisse speichern
//    foreach ($match['MatchResults'] as $resultData) {
//        $result = new Result();
//        $result
//            ->setPointsTeam1($resultData['PointsTeam1'])
//            ->setPointsTeam2($resultData['PointsTeam2']);
//
//        if ($resultData['ResultName'] === 'Halbzeitstand') {
//            $matchModel->setHalfTimeResult($result);
//        } elseif ($resultData['ResultName'] === 'Endergebnis') {
//            $matchModel->setEndResult($result);
//        }
//    }
//
//    $selectedMatches[] = $matchModel;
//}

// Objekte an die Ansicht übergeben
echo $template->render([
    'teams' => $teams,
    'selectedTeam' => $selectedTeam,
    'selectedMatches' => $selectedMatches
]);
