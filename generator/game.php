<?php

set_time_limit(0);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "TRUNCATE `player`";
$mysqli->query($sql);

$sql = "TRUNCATE `playerattribute`";
$mysqli->query($sql);

$sql = "TRUNCATE `playerposition`";
$mysqli->query($sql);

$sql = "TRUNCATE `standing`";
$mysqli->query($sql);

$sql = "TRUNCATE `broadcasting`";
$mysqli->query($sql);

$sql = "TRUNCATE `disqualification`";
$mysqli->query($sql);

$sql = "TRUNCATE `event`";
$mysqli->query($sql);

$sql = "TRUNCATE `game`";
$mysqli->query($sql);

$sql = "TRUNCATE `lineup`";
$mysqli->query($sql);

$sql = "TRUNCATE `lineupcurrent`";
$mysqli->query($sql);

$sql = "TRUNCATE `recordteam`";
$mysqli->query($sql);

$sql = "TRUNCATE `recordtournament`";
$mysqli->query($sql);

$sql = "TRUNCATE `series`";
$mysqli->query($sql);

$sql = "TRUNCATE `shedule`";
$mysqli->query($sql);

$sql = "TRUNCATE `standinghistory`";
$mysqli->query($sql);

$sql = "TRUNCATE `statisticplayer`";
$mysqli->query($sql);

$sql = "TRUNCATE `statisticreferee`";
$mysqli->query($sql);

$sql = "TRUNCATE `statisticteam`";
$mysqli->query($sql);

$sql = "TRUNCATE `statisticuser`";
$mysqli->query($sql);

$sql = "TRUNCATE `finance`";
$mysqli->query($sql);

$sql = "TRUNCATE `staff`";
$mysqli->query($sql);

$sql = "TRUNCATE `staffattribute`";
$mysqli->query($sql);

$sql = "TRUNCATE `cupparticipant`";
$mysqli->query($sql);

$sql = "TRUNCATE `leagueparticipant`";
$mysqli->query($sql);

$sql = "TRUNCATE `league`";
$mysqli->query($sql);

$sql = "INSERT INTO `player`
        SET `player_id`='0'";
$mysqli->query($sql);

$sql = "UPDATE `player`
        SET `player_id`='0'
        WHERE `player_id`='1'
        LIMIT 1";
$mysqli->query($sql);

$sql = "ALTER TABLE `player` AUTO_INCREMENT='1';";
$mysqli->query($sql);

$sql = "UPDATE `team`
        SET `team_finance`='0',
            `team_school_level`='1',
            `team_training_level`='1'
        WHERE `team_id`!='0'
        ORDER BY `team_id` ASC";
$mysqli->query($sql);

$sql = "SELECT `team_id`
        FROM `team`
        WHERE `team_id`!='0'
        ORDER BY `team_id` ASC";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_team; $i++)
{
    $team_id = $team_array[$i]['team_id'];

    for ($j=0; $j<NUMBER_PLAYER_IN_NEW_TEAM; $j++)
    {
        f_igosja_player_create($team_id, $j);
    }

    f_igosja_staff_create($team_id);
}

$sql = "UPDATE `player`
        SET `player_practice`='50',
            `player_condition`='100'";
$mysqli->query($sql);

$sql = "INSERT INTO `standing` (`standing_tournament_id`, `standing_country_id`, `standing_season_id`, `standing_team_id`)
        SELECT `tournament_id`, `city_country_id`, '$igosja_season_id', `team_id`
        FROM `team`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `tournament`
        ON `tournament_country_id`=`city_country_id`
        WHERE `team_id`!='0'
        AND `tournament_tournamenttype_id`='2'
        ORDER BY RAND()";
$mysqli->query($sql);

$shedule_insert_sql = array();

for ($i=0; $i<22; $i++)
{
    $date = date('Y-m-d');
    $date = strtotime($date . ' +' . $i . 'days');
    $date = date('Y-m-d', $date);

    $shedule_insert_sql[] = "('$date', '$igosja_season_id', '" . TOURNAMENT_TYPE_CHAMPIONS_LEAGUE . "')";
}

/* Этот блок для кубка
for ($i=0; $i<9; $i++)
{
    $date = date('Y-m-d');
    $date = strtotime($date . ' +' . $i . 'days');
    $date = date('Y-m-d', $date);

    $shedule_insert_sql[] = "('$date', '$igosja_season_id', '3')";
}*/
/* Этот блок для чемпионата - 38 туров
for ($i=0; $i<38; $i++)
{
    $date = date('Y-m-d');
    $date = strtotime($date . ' +' . $i . 'days');
    $date = date('Y-m-d', $date);

    $shedule_insert_sql[] = "('$date', '$igosja_season_id', '2')";
}
*/
$shedule_insert_sql = implode(',', $shedule_insert_sql);

$sql = "INSERT INTO `shedule` (`shedule_date`, `shedule_season_id`, `shedule_tournamenttype_id`)
        VALUES $shedule_insert_sql;";
$mysqli->query($sql);
/* календарь чемпионата страны
$sql = "SELECT `standing_country_id`,
               `standing_tournament_id`
        FROM `standing`
        WHERE `standing_season_id`='$igosja_season_id'
        GROUP BY `standing_country_id`
        ORDER BY `standing_country_id` ASC";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;
$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_country; $i++)
{
    $country_id    = $country_array[$i]['standing_country_id'];
    $tournament_id = $country_array[$i]['standing_tournament_id'];

    $sql = "SELECT `standing_team_id`
            FROM `standing`
            WHERE `standing_country_id`='$country_id'
            AND `standing_season_id`='$igosja_season_id'
            ORDER BY RAND()";
    $standing_sql = $mysqli->query($sql);

    $count_standing = $standing_sql->num_rows;
    $standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

    for($j=0; $j<$count_standing; $j++)
    {
        $team_num   = $j + 1;
        $team       = 'team_' . $team_num;
        $$team      = $standing_array[$j]['standing_team_id'];
    }

    $sql = "INSERT INTO `game`
        (
            `game_home_team_id`,
            `game_guest_team_id`,
            `game_referee_id`,
            `game_stadium_id`,
            `game_shedule_id`,
            `game_temperature`,
            `game_tournament_id`,
            `game_weather_id`
        )
        VALUES  ('$team_1','$team_2','1','$team_1','1','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_10','1','$team_12','1','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_9','1','$team_13','1','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_8','1','$team_14','1','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_7','1','$team_15','1','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_6','1','$team_16','1','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_5','1','$team_17','1','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_4','1','$team_18','1','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_3','1','$team_19','1','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_11','1','$team_20','1','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_1','1','$team_3','2','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_19','1','$team_4','2','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_18','1','$team_5','2','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_17','1','$team_6','2','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_16','1','$team_7','2','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_15','1','$team_8','2','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_14','1','$team_9','2','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_13','1','$team_10','2','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_12','1','$team_11','2','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_20','1','$team_2','2','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_4','1','$team_1','3','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_3','1','$team_2','3','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_11','1','$team_13','3','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_10','1','$team_14','3','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_9','1','$team_15','3','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_8','1','$team_16','3','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_7','1','$team_17','3','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_6','1','$team_18','3','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_5','1','$team_19','3','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_12','1','$team_20','3','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_2','1','$team_4','4','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_1','1','$team_5','4','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_19','1','$team_6','4','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_18','1','$team_7','4','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_17','1','$team_8','4','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_16','1','$team_9','4','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_15','1','$team_10','4','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_14','1','$team_11','4','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_13','1','$team_12','4','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_20','1','$team_3','4','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_6','1','$team_1','5','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_5','1','$team_2','5','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_4','1','$team_3','5','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_12','1','$team_14','5','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_11','1','$team_15','5','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_10','1','$team_16','5','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_9','1','$team_17','5','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_8','1','$team_18','5','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_7','1','$team_19','5','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_13','1','$team_20','5','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_3','1','$team_5','6','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_2','1','$team_6','6','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_1','1','$team_7','6','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_19','1','$team_8','6','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_18','1','$team_9','6','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_17','1','$team_10','6','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_16','1','$team_11','6','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_15','1','$team_12','6','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_14','1','$team_13','6','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_20','1','$team_4','6','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_8','1','$team_1','7','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_7','1','$team_2','7','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_6','1','$team_3','7','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_5','1','$team_4','7','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_13','1','$team_15','7','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_12','1','$team_16','7','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_11','1','$team_17','7','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_10','1','$team_18','7','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_9','1','$team_19','7','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_14','1','$team_20','7','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_4','1','$team_6','8','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_3','1','$team_7','8','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_2','1','$team_8','8','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_1','1','$team_9','8','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_19','1','$team_10','8','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_18','1','$team_11','8','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_17','1','$team_12','8','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_16','1','$team_13','8','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_15','1','$team_14','8','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_20','1','$team_5','8','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_10','1','$team_1','9','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_9','1','$team_2','9','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_8','1','$team_3','9','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_7','1','$team_4','9','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_6','1','$team_5','9','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_14','1','$team_16','9','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_13','1','$team_17','9','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_12','1','$team_18','9','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_11','1','$team_19','9','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_15','1','$team_20','9','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_5','1','$team_7','10','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_4','1','$team_8','10','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_3','1','$team_9','10','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_2','1','$team_10','10','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_1','1','$team_11','10','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_19','1','$team_12','10','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_18','1','$team_13','10','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_17','1','$team_14','10','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_16','1','$team_15','10','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_20','1','$team_6','10','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_12','1','$team_1','11','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_11','1','$team_2','11','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_10','1','$team_3','11','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_9','1','$team_4','11','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_8','1','$team_5','11','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_7','1','$team_6','11','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_15','1','$team_17','11','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_14','1','$team_18','11','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_13','1','$team_19','11','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_16','1','$team_20','11','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_6','1','$team_8','12','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_5','1','$team_9','12','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_4','1','$team_10','12','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_3','1','$team_11','12','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_2','1','$team_12','12','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_1','1','$team_13','12','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_19','1','$team_14','12','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_18','1','$team_15','12','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_17','1','$team_16','12','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_20','1','$team_7','12','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_14','1','$team_1','13','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_13','1','$team_2','13','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_12','1','$team_3','13','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_11','1','$team_4','13','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_10','1','$team_5','13','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_9','1','$team_6','13','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_8','1','$team_7','13','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_16','1','$team_18','13','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_15','1','$team_19','13','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_17','1','$team_20','13','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_7','1','$team_9','14','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_6','1','$team_10','14','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_5','1','$team_11','14','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_4','1','$team_12','14','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_3','1','$team_13','14','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_2','1','$team_14','14','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_1','1','$team_15','14','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_19','1','$team_16','14','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_18','1','$team_17','14','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_20','1','$team_8','14','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_16','1','$team_1','15','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_15','1','$team_2','15','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_14','1','$team_3','15','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_13','1','$team_4','15','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_12','1','$team_5','15','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_11','1','$team_6','15','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_10','1','$team_7','15','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_9','1','$team_8','15','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_17','1','$team_19','15','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_18','1','$team_20','15','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_8','1','$team_10','16','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_7','1','$team_11','16','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_6','1','$team_12','16','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_5','1','$team_13','16','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_4','1','$team_14','16','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_3','1','$team_15','16','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_2','1','$team_16','16','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_1','1','$team_17','16','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_19','1','$team_18','16','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_20','1','$team_9','16','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_18','1','$team_1','17','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_17','1','$team_2','17','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_16','1','$team_3','17','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_15','1','$team_4','17','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_14','1','$team_5','17','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_13','1','$team_6','17','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_12','1','$team_7','17','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_11','1','$team_8','17','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_10','1','$team_9','17','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_19','1','$team_20','17','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_9','1','$team_11','18','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_8','1','$team_12','18','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_7','1','$team_13','18','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_6','1','$team_14','18','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_5','1','$team_15','18','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_4','1','$team_16','18','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_3','1','$team_17','18','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_2','1','$team_18','18','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_1','1','$team_19','18','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_20','1','$team_10','18','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_20','1','$team_1','19','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_19','1','$team_2','19','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_18','1','$team_3','19','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_17','1','$team_4','19','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_16','1','$team_5','19','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_15','1','$team_6','19','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_14','1','$team_7','19','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_13','1','$team_8','19','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_12','1','$team_9','19','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_11','1','$team_10','19','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_1','1','$team_2','20','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_12','1','$team_10','20','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_13','1','$team_9','20','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_14','1','$team_8','20','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_15','1','$team_7','20','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_16','1','$team_6','20','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_17','1','$team_5','20','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_18','1','$team_4','20','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_19','1','$team_3','20','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_20','1','$team_11','20','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_3','1','$team_1','21','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_4','1','$team_19','21','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_5','1','$team_18','21','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_6','1','$team_17','21','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_7','1','$team_16','21','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_8','1','$team_15','21','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_9','1','$team_14','21','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_10','1','$team_13','21','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_11','1','$team_12','21','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_2','1','$team_20','21','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_1','1','$team_4','22','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_2','1','$team_3','22','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_13','1','$team_11','22','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_14','1','$team_10','22','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_15','1','$team_9','22','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_16','1','$team_8','22','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_17','1','$team_7','22','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_18','1','$team_6','22','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_19','1','$team_5','22','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_20','1','$team_12','22','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_4','1','$team_2','23','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_5','1','$team_1','23','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_6','1','$team_19','23','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_7','1','$team_18','23','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_8','1','$team_17','23','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_9','1','$team_16','23','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_10','1','$team_15','23','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_11','1','$team_14','23','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_12','1','$team_13','23','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_3','1','$team_20','23','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_1','1','$team_6','24','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_2','1','$team_5','24','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_3','1','$team_4','24','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_14','1','$team_12','24','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_15','1','$team_11','24','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_16','1','$team_10','24','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_17','1','$team_9','24','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_18','1','$team_8','24','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_19','1','$team_7','24','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_20','1','$team_13','24','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_5','1','$team_3','25','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_6','1','$team_2','25','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_7','1','$team_1','25','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_8','1','$team_19','25','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_9','1','$team_18','25','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_10','1','$team_17','25','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_11','1','$team_16','25','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_12','1','$team_15','25','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_13','1','$team_14','25','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_4','1','$team_20','25','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_1','1','$team_8','26','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_2','1','$team_7','26','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_3','1','$team_6','26','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_4','1','$team_5','26','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_15','1','$team_13','26','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_16','1','$team_12','26','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_17','1','$team_11','26','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_18','1','$team_10','26','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_19','1','$team_9','26','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_20','1','$team_14','26','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_6','1','$team_4','27','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_7','1','$team_3','27','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_8','1','$team_2','27','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_9','1','$team_1','27','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_10','1','$team_19','27','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_11','1','$team_18','27','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_12','1','$team_17','27','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_13','1','$team_16','27','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_14','1','$team_15','27','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_5','1','$team_20','27','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_1','1','$team_10','28','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_2','1','$team_9','28','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_3','1','$team_8','28','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_4','1','$team_7','28','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_5','1','$team_6','28','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_16','1','$team_14','28','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_17','1','$team_13','28','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_18','1','$team_12','28','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_19','1','$team_11','28','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_20','1','$team_15','28','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_7','1','$team_5','29','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_8','1','$team_4','29','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_9','1','$team_3','29','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_10','1','$team_2','29','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_11','1','$team_1','29','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_12','1','$team_19','29','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_13','1','$team_18','29','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_14','1','$team_17','29','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_15','1','$team_16','29','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_6','1','$team_20','29','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_1','1','$team_12','30','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_2','1','$team_11','30','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_3','1','$team_10','30','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_4','1','$team_9','30','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_5','1','$team_8','30','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_6','1','$team_7','30','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_17','1','$team_15','30','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_18','1','$team_14','30','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_19','1','$team_13','30','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_20','1','$team_16','30','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_8','1','$team_6','31','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_9','1','$team_5','31','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_10','1','$team_4','31','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_11','1','$team_3','31','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_12','1','$team_2','31','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_13','1','$team_1','31','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_14','1','$team_19','31','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_15','1','$team_18','31','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_16','1','$team_17','31','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_7','1','$team_20','31','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_1','1','$team_14','32','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_2','1','$team_13','32','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_3','1','$team_12','32','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_4','1','$team_11','32','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_5','1','$team_10','32','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_6','1','$team_9','32','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_7','1','$team_8','32','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_18','1','$team_16','32','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_19','1','$team_15','32','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_20','1','$team_17','32','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_9','1','$team_7','33','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_10','1','$team_6','33','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_11','1','$team_5','33','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_12','1','$team_4','33','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_13','1','$team_3','33','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_14','1','$team_2','33','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_15','1','$team_1','33','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_16','1','$team_19','33','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_17','1','$team_18','33','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_8','1','$team_20','33','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_1','1','$team_16','34','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_2','1','$team_15','34','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_3','1','$team_14','34','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_4','1','$team_13','34','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_5','1','$team_12','34','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_6','1','$team_11','34','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_7','1','$team_10','34','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_8','1','$team_9','34','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_19','1','$team_17','34','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_20','1','$team_18','34','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_10','1','$team_8','35','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_11','1','$team_7','35','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_12','1','$team_6','35','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_13','1','$team_5','35','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_14','1','$team_4','35','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_15','1','$team_3','35','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_16','1','$team_2','35','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_17','1','$team_1','35','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_18','1','$team_19','35','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_9','1','$team_20','35','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_1','1','$team_18','36','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_2','1','$team_17','36','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_3','1','$team_16','36','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_4','1','$team_15','36','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_5','1','$team_14','36','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_6','1','$team_13','36','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_7','1','$team_12','36','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_8','1','$team_11','36','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_9','1','$team_10','36','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_20','1','$team_19','36','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9','$team_11','1','$team_9','37','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8','$team_12','1','$team_8','37','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7','$team_13','1','$team_7','37','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6','$team_14','1','$team_6','37','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5','$team_15','1','$team_5','37','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4','$team_16','1','$team_4','37','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3','$team_17','1','$team_3','37','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2','$team_18','1','$team_2','37','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1','$team_19','1','$team_1','37','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_10','1','$team_20','37','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_1','1','$team_20','38','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_2','1','$team_19','38','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_3','1','$team_18','38','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_4','1','$team_17','38','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_5','1','$team_16','38','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_6','1','$team_15','38','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_7','1','$team_14','38','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_8','1','$team_13','38','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_9','1','$team_12','38','15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_10','1','$team_11','38','15'+RAND()*'15','$tournament_id','1'+RAND()*'3');";
    $mysqli->query($sql);
}
*/
/*
$sql = "SELECT `tournament_id`,
               `tournament_country_id`
        FROM `tournament`
        WHERE `tournament_tournamenttype_id`='3'
        ORDER BY `tournament_country_id` ASC";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;
$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_country; $i++)
{
    $country_id     = $country_array[$i]['tournament_country_id'];
    $tournament_id  = $country_array[$i]['tournament_id'];

    $sql = "INSERT INTO `cupparticipant` (`cupparticipant_team_id`, `cupparticipant_tournament_id`)
            SELECT `team_id`, '$tournament_id'
            FROM `team`
            LEFT JOIN `city`
            ON `team_city_id`=`city_id`
            WHERE `city_country_id`='$country_id'";
    $mysqli->query($sql);

    $sql = "SELECT `cupparticipant_team_id`
            FROM `cupparticipant`
            WHERE `cupparticipant_tournament_id`='$tournament_id'
            ORDER BY RAND()
            LIMIT 8";
    $team_sql = $mysqli->query($sql);

    $count_team = $team_sql->num_rows;
    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    for ($j=0; $j<$count_team; $j=$j+2)
    {
        $team_1 = $team_array[$j]['cupparticipant_team_id'];
        $team_2 = $team_array[$j+1]['cupparticipant_team_id'];

        $sql = "INSERT INTO `game`
                SET `game_guest_team_id`='$team_2',
                    `game_home_team_id`='$team_1',
                    `game_referee_id`='1',
                    `game_stadium_id`='$team_1',
                    `game_stage_id`='45',
                    `game_shedule_id`='1',
                    `game_temperature`='15'+RAND()*'15',
                    `game_tournament_id`='$tournament_id',
                    `game_weather_id`='1'+RAND()*'3'";
        $mysqli->query($sql);

        $game_id = $mysqli->insert_id;

        $sql = "INSERT INTO `game`
                SET `game_first_game_id`='$game_id',
                    `game_guest_team_id`='$team_1',
                    `game_home_team_id`='$team_2',
                    `game_referee_id`='1',
                    `game_stadium_id`='$team_2',
                    `game_stage_id`='45',
                    `game_shedule_id`='2',
                    `game_temperature`='15'+RAND()*'15',
                    `game_tournament_id`='$tournament_id',
                    `game_weather_id`='1'+RAND()*'3'";
        $mysqli->query($sql);
    }
}
*/

$sql = "INSERT INTO `leagueparticipant` (`leagueparticipant_team_id`)
        SELECT `team_id`
        FROM `team`
        WHERE `team_id`!='0'
        ORDER BY RAND()";
$mysqli->query($sql);

$sql = "UPDATE `leagueparticipant`
        SET `leagueparticipant_in`='39'
        WHERE `leagueparticipant_in`='0'
        LIMIT 4";
$mysqli->query($sql);

$sql = "UPDATE `leagueparticipant`
        SET `leagueparticipant_in`='40'
        WHERE `leagueparticipant_in`='0'
        LIMIT 2";
$mysqli->query($sql);

$sql = "UPDATE `leagueparticipant`
        SET `leagueparticipant_in`='41'
        WHERE `leagueparticipant_in`='0'
        LIMIT 2";
$mysqli->query($sql);

$sql = "UPDATE `leagueparticipant`
        SET `leagueparticipant_in`='42'
        WHERE `leagueparticipant_in`='0'
        LIMIT 2";
$mysqli->query($sql);

$sql = "UPDATE `leagueparticipant`
        SET `leagueparticipant_in`='1'
        WHERE `leagueparticipant_in`='0'";
$mysqli->query($sql);

$sql = "SELECT `leagueparticipant_team_id`
        FROM `leagueparticipant`
        ORDER BY `leagueparticipant_id` ASC
        LIMIT 4";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_team; $i=$i+2)
{
    $team_1 = $team_array[$i]['leagueparticipant_team_id'];
    $team_2 = $team_array[$i+1]['leagueparticipant_team_id'];

    $sql = "INSERT INTO `game`
            SET `game_guest_team_id`='$team_2',
                `game_home_team_id`='$team_1',
                `game_referee_id`='1',
                `game_stadium_id`='$team_1',
                `game_stage_id`='39',
                `game_shedule_id`='1',
                `game_temperature`='15'+RAND()*'15',
                `game_tournament_id`='" . TOURNAMENT_CHAMPIONS_LEAGUE . "',
                `game_weather_id`='1'+RAND()*'3'";
    $mysqli->query($sql);

    $game_id = $mysqli->insert_id;

    $sql = "INSERT INTO `game`
            SET `game_first_game_id`='$game_id',
                `game_guest_team_id`='$team_1',
                `game_home_team_id`='$team_2',
                `game_referee_id`='1',
                `game_stadium_id`='$team_2',
                `game_stage_id`='39',
                `game_shedule_id`='2',
                `game_temperature`='15'+RAND()*'15',
                `game_tournament_id`='" . TOURNAMENT_CHAMPIONS_LEAGUE . "',
                `game_weather_id`='1'+RAND()*'3'";
    $mysqli->query($sql);
}

print '<br/>Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br/>Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';