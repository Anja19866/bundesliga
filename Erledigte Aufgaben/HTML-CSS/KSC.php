<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>-->
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>-->

    <title>Aufgabe b mit Bootstrap</title>

</head>
<body>

<div class="container">
    <h2>KSC Successes in Striped Rows</h2>
    <p>The .table-striped class adds zebra-stripes to a table:</p>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Team 1</th>
            <th>Team 2</th>
            <th>Results or Date</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $content = file_get_contents('https://www.openligadb.de/api/getmatchdata/bl3/2018');
        $matches = json_decode($content, true);

        foreach ($matches as $match) {

            $team1 = $match['Team1'];
            $team2 = $match['Team2'];

            $team1Icon = $team1['TeamIconUrl'];
            $team2Icon = $team2['TeamIconUrl'];

            $team1Name = $team1['TeamName'];
            $team2Name = $team2['TeamName'];

            if ($match['Team1']['TeamId'] == 105 || $match['Team2']['TeamId'] == 105) {

                echo "<tr>\n";
                echo "<td><img src='$team1Icon' width='15'/> $team1Name</td>\n";
                echo "<td><img src='$team2Icon' width='15'/> $team2Name</td>\n";
                if (isset($match['MatchResults'][1]['PointsTeam1'])) {
                    echo "<td>" . $match['MatchResults'][1]['PointsTeam1'] . ":" . $match['MatchResults'][1]['PointsTeam2'] . " (" .
                        $match['MatchResults'][1]['PointsTeam2'] . ":" . $match['MatchResults'][1]['PointsTeam2'] . ") </td>\n";
                }
                else { echo "<td>" . date('d.m.Y H:i', strtotime($match['MatchDateTimeUTC'])) . " Uhr</td>\n";
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