<!DOCTYPE html>
<html lang="en">
<head>

    <?php
    $content = file_get_contents('https://www.openligadb.de/api/getmatchdata/bl3/2018/1');
    $matches = json_decode($content, true);
    ?>

    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <title>Fussball Ergebnisse - 3. Liga</title>
</head>
<body>

<div class="container">

<h2>Fussball Ergebnisse - 3. Liga</h2>

    <table>
        <thead>
        <tr>
            <th>Team 1</th>
            <th>Team 2</th>
            <th>Results</th>
            <th>Time</th>
        </tr>
        </thead>
        <?php
        foreach ($matches as $match) {

            $team1 = $match['Team1'];
            $team2 = $match['Team2'];

            $team1Icon = $team1['TeamIconUrl'];
            $team2Icon = $team2['TeamIconUrl'];

            $team1Name = $team1['TeamName'];
            $team2Name = $team2['TeamName'];

            echo "<tbody>\n";
                echo "<tr>\n";
                    echo "<td><img src='$team1Icon' width='15'/> $team1Name</td>\n";
                    echo "<td><img src='$team2Icon' width='15'/> $team2Name</td>\n";
                    echo "<td>" . $match['MatchResults'][1]['PointsTeam1'] . ":" .
                                $match['MatchResults'][1]['PointsTeam2'] . " (" .
                                $match['MatchResults'][0]['PointsTeam1'] . ":" .
                                $match['MatchResults'][0]['PointsTeam2'] . ") </td>\n";
                    echo "<td>" . date('H:i', strtotime($match['MatchDateTimeUTC'])) . " Uhr</td>\n";
                echo "</tr>\n";
            echo "</tbody>\n";
        }
        ?>
    </table>
</div>

</body>
</html>