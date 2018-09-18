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
    <h2>Team auswählen</h2>

    <?php


    $teams = [];
    foreach ($matches as $match) {
        $teamId = $match['Team1']['TeamId'];
        $teamName = $match['Team1']['TeamName'];
        $teams[] = $teamName;
    }
    $teams = array_unique($teams);

    sort($teams);

    echo "<table id='list'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Team-Liste</th>\n";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($teams as $i => $team) {
        echo "<tr>\n";
        echo "<td>" . ++$i . ". " . $team . "</td>\n";
        echo "</tr>\n";
    }
    echo "</tbody>";
    echo "</table>";

    ?>
</div>
<div class="container">

    <form action="teamErgebnisse.php" method="post">
        <label for="Eingabe" class="form__label">Gewünschte Team-Nr. eingeben: </label>
        <input type="text" class="form__input" placeholder="Nr." name="Eingabe">
        <input type="Submit" value="Absenden">
    </form>

    <h2>Ergebnisse des ausgewählten Teams</h2>

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

        if (!EMPTY($_POST['Eingabe'])) {
            $teamNumber = $_POST['Eingabe'] - 1;
            $selectedTeamName = $teams[$teamNumber];
        }
        else {
            $selectedTeamName = "Karlsruher SC";
        }

        foreach ($matches as $match) {
//           echo '<pre>',var_dump($match['Team1']),'</pre>';

            $team1 = $match['Team1'];
            $team2 = $match['Team2'];

            $team1Icon = $team1['TeamIconUrl'];
            $team2Icon = $team2['TeamIconUrl'];

            $team1Name = $team1['TeamName'];
            $team2Name = $team2['TeamName'];


                if ($match['Team1']['TeamName'] === $selectedTeamName || $match['Team2']['TeamName'] === $selectedTeamName) {

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