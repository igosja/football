<?php

include($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT `league_group`
        FROM `league`
        WHERE `league_season_id`='$igosja_season_id'
        GROUP BY `league_group`
        ORDER BY `league_group` ASC";
$league_sql = $mysqli->query($sql);

$count_league = $league_sql->num_rows;
$league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

for ($i = 0; $i < $count_league; $i++) {
    $group = $league_array[$i]['league_group'];

    $sql = "SELECT `league_id`
            FROM `league`
            WHERE `league_group`='$group'
            AND `league_season_id`='$igosja_season_id'
            ORDER BY `league_point` DESC, `league_score`-`league_pass` DESC, `league_score` DESC";
    $league_sql = $mysqli->query($sql);

    $count_league = $league_sql->num_rows;
    $league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

    for ($j = 0; $j < $count_league; $j++) {
        $league_id = $league_array[$j]['league_id'];

        $place = $j + 1;

        $sql = "UPDATE `league`
                    SET `league_place`='$place'
                    WHERE `league_id`='$league_id'";
        $mysqli->query($sql);
    }
}