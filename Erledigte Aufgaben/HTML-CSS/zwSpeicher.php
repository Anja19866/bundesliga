<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">

    <?php
    $content = file_get_contents('https://www.openligadb.de/api/getmatchdata/bl3/2018');
    $matches = json_decode($content, true);
    ?>

    <title>Ergebnisse für ausgewähltes Team</title>

</head>
<body>

<div class="container">

    <?php


    $teams = [];
    foreach ($matches as $match) {
        $teamId = $match['Team1']['TeamId'];
        $teams[$teamId] = $match['Team1'];
    }

    //    echo '<pre>';
    //    var_dump($teams);
    //    die();

    usort($teams, function ($teamA, $teamB) {
        return strcmp($teamA['TeamName'], $teamB['TeamName']);
    });

    echo "<table id='list'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Team auswählen</th>\n";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($teams as $i => $team) {
        echo "<tr>\n";
        echo "<td>";
        echo "<a href='?id=" . $i . "'>";
        echo ++$i . ". <img src='" . $team['TeamIconUrl'] . "' width='15'/> " . $team['TeamName'];
        echo "</a>";
        echo "</td>";
        echo "</tr>\n";
    }
    echo "</tbody>";
    echo "</table>";

    ?>
</div>
<div class="container">

    <table>
        <thead>
        <tr>
            <th>Team 1</th>
            <th>Team 2</th>
            <th>Results or Date</th>
        </tr>
        </thead>
        <tbody>
        <?php

        //       $team['TeamId'] = $_GET['id'];

        if (isset($_GET['id'])) {
            $teamNumber= $_GET['id'];
            $team['TeamName'] = $teams[$teamNumber];
        }
        else {
            $team['TeamName'] = "Karlsruher SC";
        }

        echo "<pre>";
        var_dump($team['TeamName']);

        echo "<h2>Gewähltes Team: <img src='" . $team['TeamIconUrl'] . "' width='20'/> " . $team['TeamName'] . "</h2>";

        foreach ($matches as $match) {

//           echo '<pre>',var_dump($match['Team1']),'</pre>';

            $team1 = $match['Team1'];
            $team2 = $match['Team2'];

            $team1Icon = $team1['TeamIconUrl'];
            $team2Icon = $team2['TeamIconUrl'];

            $team1Name = $team1['TeamName'];
            $team2Name = $team2['TeamName'];

            if ($match['Team1']['TeamName'] === $team['TeamName'] || $match['Team2']['TeamName'] === $team['TeamName']) {

                echo "<tr>\n";
                echo "<td><img src='$team1Icon' width='15'/> $team1Name</td>\n";
                echo "<td><img src='$team2Icon' width='15'/> $team2Name</td>\n";
                if (isset($match['MatchResults'][1]['PointsTeam1'])) {
                    echo "<td>" . $match['MatchResults'][1]['PointsTeam1'] . ":" . $match['MatchResults'][1]['PointsTeam2'] . " (" .
                        $match['MatchResults'][1]['PointsTeam2'] . ":" . $match['MatchResults'][1]['PointsTeam2'] . ") </td>\n";
                } else {
                    echo "<td>" . date('d.m.Y H:i', strtotime($match['MatchDateTimeUTC'])) . " Uhr</td>\n";
                }
                echo "</tr>\n";
            }
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>