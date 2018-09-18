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

    <h2>All Teams</h2>

    <h3>Choose Team</h3>

    <?php

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

    echo "<ul>";

    foreach ($teams as $team) {
        echo "<li class='" . ($team['TeamId'] === $selectedTeam['TeamId'] ? 'current' : '') . "'>";
        echo "<a href='?id=" . $team['TeamId'] . "'>";
        echo "<img src='" . $team['TeamIconUrl'] . "' width='15'> " . $team['TeamName'] . "</a>";
        echo "</li>";
    }

    echo "</ul>";
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

        echo "<h2>Selected Team: <img src='" . $selectedTeam['TeamIconUrl'] . "' width='25'> " . $selectedTeam['TeamName'] . "</h2>";

        foreach ($matches as $match) {

//           echo '<pre>',var_dump($match['Team1']),'</pre>';

            $team1 = $match['Team1'];
            $team2 = $match['Team2'];

            $team1Icon = $team1['TeamIconUrl'];
            $team2Icon = $team2['TeamIconUrl'];

            $team1Name = $team1['TeamName'];
            $team2Name = $team2['TeamName'];

            if ($match['Team1']['TeamName'] === $selectedTeam['TeamName'] || $match['Team2']['TeamName'] === $selectedTeam['TeamName']) {

                echo "<tr>\n";
                echo "<td class='teams'><img src='$team1Icon' width='15'/> $team1Name</td>\n";
                echo "<td class='teams'><img src='$team2Icon' width='15'/> $team2Name</td>\n";
                if (isset($match['MatchResults'][1]['PointsTeam1'])) {
                    echo "<td class='teams'>" . $match['MatchResults'][1]['PointsTeam1'] . ":" . $match['MatchResults'][1]['PointsTeam2'] . " (" .
                        $match['MatchResults'][1]['PointsTeam2'] . ":" . $match['MatchResults'][1]['PointsTeam2'] . ") </td>\n";
                } else {
                    echo "<td class='teams'>" . date('d.m.Y H:i', strtotime($match['MatchDateTimeUTC'])) . " Uhr</td>\n";
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