<?php

set_time_limit(0);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "TRUNCATE `asktoplay`";
$mysqli->query($sql);

$sql = "TRUNCATE `building`";
$mysqli->query($sql);

$sql = "TRUNCATE `cupparticipant`";
$mysqli->query($sql);

$sql = "TRUNCATE `disqualification`";
$mysqli->query($sql);

$sql = "TRUNCATE `event`";
$mysqli->query($sql);

$sql = "TRUNCATE `finance`";
$mysqli->query($sql);

$sql = "TRUNCATE `game`";
$mysqli->query($sql);

$sql = "TRUNCATE `history`";
$mysqli->query($sql);

$sql = "TRUNCATE `historyfinanceteam`";
$mysqli->query($sql);

$sql = "TRUNCATE `historyfinanceuser`";
$mysqli->query($sql);

$sql = "TRUNCATE `inbox`";
$mysqli->query($sql);

$sql = "TRUNCATE `injury`";
$mysqli->query($sql);

$sql = "TRUNCATE `league`";
$mysqli->query($sql);

$sql = "TRUNCATE `leagueparticipant`";
$mysqli->query($sql);

$sql = "TRUNCATE `lineup`";
$mysqli->query($sql);

$sql = "TRUNCATE `lineupmain`";
$mysqli->query($sql);

$sql = "TRUNCATE `player`";
$mysqli->query($sql);

$sql = "TRUNCATE `playerattribute`";
$mysqli->query($sql);

$sql = "TRUNCATE `playeroffer`";
$mysqli->query($sql);

$sql = "TRUNCATE `playerposition`";
$mysqli->query($sql);

$sql = "TRUNCATE `recordcountry`";
$mysqli->query($sql);

$sql = "TRUNCATE `recordteam`";
$mysqli->query($sql);

$sql = "TRUNCATE `recordtournament`";
$mysqli->query($sql);

$sql = "TRUNCATE `referee`";
$mysqli->query($sql);

$sql = "TRUNCATE `rent`";
$mysqli->query($sql);

$sql = "TRUNCATE `robokassa`";
$mysqli->query($sql);

$sql = "TRUNCATE `scout`";
$mysqli->query($sql);

$sql = "TRUNCATE `series`";
$mysqli->query($sql);

$sql = "TRUNCATE `shedule`";
$mysqli->query($sql);

$sql = "TRUNCATE `staff`";
$mysqli->query($sql);

$sql = "TRUNCATE `staffattribute`";
$mysqli->query($sql);

$sql = "TRUNCATE `standing`";
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

$sql = "TRUNCATE `teaminstruction`";
$mysqli->query($sql);

$sql = "TRUNCATE `training`";
$mysqli->query($sql);

$sql = "TRUNCATE `transfer`";
$mysqli->query($sql);

$sql = "TRUNCATE `transferhistory`";
$mysqli->query($sql);

$sql = "TRUNCATE `trophyplayer`";
$mysqli->query($sql);

$sql = "TRUNCATE `userformation`";
$mysqli->query($sql);

$sql = "TRUNCATE `usergamemood`";
$mysqli->query($sql);

$sql = "TRUNCATE `usergamestyle`";
$mysqli->query($sql);

$sql = "TRUNCATE `worldcup`";
$mysqli->query($sql);

$sql = "INSERT INTO `player`
        SET `player_id`='0'";
$mysqli->query($sql);

$sql = "UPDATE `player`
        SET `player_id`='0'
        WHERE `player_id`='1'
        LIMIT 1";
$mysqli->query($sql);

$sql = "ALTER TABLE `player` AUTO_INCREMENT=1";
$mysqli->query($sql);

$sql = "UPDATE `user`
        SET `user_reputation`='0'
        WHERE `user_id`!='0'";
$mysqli->query($sql);

$sql = "UPDATE `country`
        SET `country_user_id`='0'
        WHERE `country_user_id`!='0'";
$mysqli->query($sql);

$sql = "UPDATE `tournament`
        SET `tournament_reputation`='0'
        WHERE `tournament_id`!='0'";
$mysqli->query($sql);

$sql = "UPDATE `team`
        SET `team_finance`='0',
            `team_price`='0',
            `team_school_level`='1',
            `team_training_level`='1',
            `team_user_id`='0'
        WHERE `team_id`!='0'";
$mysqli->query($sql);

$sql = "UPDATE `stadium`
        SET `stadium_capacity`='100',
            `stadium_length`='105',
            `stadium_stadiumquality_id`='1',
            `stadium_width`='68'
        WHERE `stadium_team_id`!='0'";
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
            `player_condition`='100',
            `player_national_id`=`player_country_id`";
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

for ($i=0; $i<70; $i++)
{
    $date = date('Y-m-d');
    $date = strtotime($date . ' +' . $i . 'days');
    $date = date('Y-m-d', $date);

    if (14 > $i || 61 == $i)
    {
        $tournament_type = TOURNAMENT_TYPE_FRIENDLY;
    }
    elseif (62 < $i)
    {
        $tournament_type = TOURNAMENT_TYPE_OFF_SEASON;
    }
    elseif (in_array($i, array(16, 20, 23, 27, 37, 41, 44, 47, 58)))
    {
        $tournament_type = TOURNAMENT_TYPE_CUP;
    }
    else
    {
        $tournament_type = TOURNAMENT_TYPE_CHAMPIONSHIP;
    }

    $shedule_insert_sql[] = "('$date', '$igosja_season_id', '$tournament_type')";
}

$shedule_insert_sql = implode(',', $shedule_insert_sql);

$sql = "INSERT INTO `shedule` (`shedule_date`, `shedule_season_id`, `shedule_tournamenttype_id`)
        VALUES $shedule_insert_sql;";
$mysqli->query($sql);

$sql = "SELECT `shedule_id`
        FROM `shedule`
        WHERE `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONSHIP . "'
        AND `shedule_season_id`='$igosja_season_id'";
$shedule_sql = $mysqli->query($sql);

$count_shedule = $shedule_sql->num_rows;
$shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_shedule; $i++)
{
    $shedule  = 'shedule_' . ($i + 1);
    $$shedule = $shedule_array[$i]['shedule_id'];
}

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
    $country_id = $country_array[$i]['standing_country_id'];

    for ($j=0; $j<30; $j++)
    {
        f_igosja_referee_create($country_id);
    }

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

    $sql = "SELECT `referee_id`
            FROM `referee`
            WHERE `referee_country_id`='$country_id'
            ORDER BY `referee_reputation` DESC
            LIMIT 30";
    $referee_sql = $mysqli->query($sql);

    $count_referee = $referee_sql->num_rows;
    $referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

    for ($j=0; $j<$count_referee; $j++)
    {
        $referee  = 'referee_' . ($j + 1);
        $$referee = $referee_array[$j]['referee_id'];
    }

    $sql = "INSERT INTO `game`
        (
            `game_home_team_id`,
            `game_guest_team_id`,
            `game_referee_id`,
            `game_stadium_id`,
            `game_stage_id`,
            `game_shedule_id`,
            `game_temperature`,
            `game_tournament_id`,
            `game_weather_id`
        )
        VALUES  ('$team_1', '$team_2',  '$referee_1',   '$team_1',  '1',    '$shedule_1',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_10', '$referee_2',   '$team_12', '1',    '$shedule_1',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_9',  '$referee_3',   '$team_13', '1',    '$shedule_1',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_8',  '$referee_4',   '$team_14', '1',    '$shedule_1',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_7',  '$referee_5',   '$team_15', '1',    '$shedule_1',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_6',  '$referee_6',   '$team_16', '1',    '$shedule_1',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_5',  '$referee_7',   '$team_17', '1',    '$shedule_1',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_4',  '$referee_8',   '$team_18', '1',    '$shedule_1',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_3',  '$referee_9',   '$team_19', '1',    '$shedule_1',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_11', '$referee_10',  '$team_20', '1',    '$shedule_1',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_1',  '$referee_11',  '$team_3',  '2',    '$shedule_2',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_19', '$referee_12',  '$team_4',  '2',    '$shedule_2',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_18', '$referee_13',  '$team_5',  '2',    '$shedule_2',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_17', '$referee_14',  '$team_6',  '2',    '$shedule_2',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_16', '$referee_15',  '$team_7',  '2',    '$shedule_2',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_15', '$referee_16',  '$team_8',  '2',    '$shedule_2',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_14', '$referee_17',  '$team_9',  '2',    '$shedule_2',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_13', '$referee_18',  '$team_10', '2',    '$shedule_2',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_12', '$referee_19',  '$team_11', '2',    '$shedule_2',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_20', '$referee_20',  '$team_2',  '2',    '$shedule_2',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_4',  '$referee_21',  '$team_1',  '3',    '$shedule_3',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_3',  '$referee_22',  '$team_2',  '3',    '$shedule_3',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_11', '$referee_23',  '$team_13', '3',    '$shedule_3',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_10', '$referee_24',  '$team_14', '3',    '$shedule_3',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_9',  '$referee_25',  '$team_15', '3',    '$shedule_3',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_8',  '$referee_26',  '$team_16', '3',    '$shedule_3',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_7',  '$referee_27',  '$team_17', '3',    '$shedule_3',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_6',  '$referee_28',  '$team_18', '3',    '$shedule_3',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_5',  '$referee_29',  '$team_19', '3',    '$shedule_3',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_12', '$referee_30',  '$team_20', '3',    '$shedule_3',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_2',  '$referee_1',   '$team_4',  '4',    '$shedule_4',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_1',  '$referee_2',   '$team_5',  '4',    '$shedule_4',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_19', '$referee_3',   '$team_6',  '4',    '$shedule_4',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_18', '$referee_4',   '$team_7',  '4',    '$shedule_4',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_17', '$referee_5',   '$team_8',  '4',    '$shedule_4',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_16', '$referee_6',   '$team_9',  '4',    '$shedule_4',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_15', '$referee_7',   '$team_10', '4',    '$shedule_4',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_14', '$referee_8',   '$team_11', '4',    '$shedule_4',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_13', '$referee_9',   '$team_12', '4',    '$shedule_4',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_20', '$referee_10',  '$team_3',  '4',    '$shedule_4',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_6',  '$referee_11',  '$team_1',  '5',    '$shedule_5',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_5',  '$referee_12',  '$team_2',  '5',    '$shedule_5',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_4',  '$referee_13',  '$team_3',  '5',    '$shedule_5',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_12', '$referee_14',  '$team_14', '5',    '$shedule_5',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_11', '$referee_15',  '$team_15', '5',    '$shedule_5',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_10', '$referee_16',  '$team_16', '5',    '$shedule_5',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_9',  '$referee_17',  '$team_17', '5',    '$shedule_5',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_8',  '$referee_18',  '$team_18', '5',    '$shedule_5',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_7',  '$referee_19',  '$team_19', '5',    '$shedule_5',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_13', '$referee_20',  '$team_20', '5',    '$shedule_5',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_3',  '$referee_21',  '$team_5',  '6',    '$shedule_6',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_2',  '$referee_22',  '$team_6',  '6',    '$shedule_6',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_1',  '$referee_23',  '$team_7',  '6',    '$shedule_6',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_19', '$referee_24',  '$team_8',  '6',    '$shedule_6',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_18', '$referee_25',  '$team_9',  '6',    '$shedule_6',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_17', '$referee_26',  '$team_10', '6',    '$shedule_6',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_16', '$referee_27',  '$team_11', '6',    '$shedule_6',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_15', '$referee_28',  '$team_12', '6',    '$shedule_6',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_14', '$referee_29',  '$team_13', '6',    '$shedule_6',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_20', '$referee_30',  '$team_4',  '6',    '$shedule_6',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_8',  '$referee_1',   '$team_1',  '7',    '$shedule_7',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_7',  '$referee_2',   '$team_2',  '7',    '$shedule_7',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_6',  '$referee_3',   '$team_3',  '7',    '$shedule_7',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_5',  '$referee_4',   '$team_4',  '7',    '$shedule_7',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_13', '$referee_5',   '$team_15', '7',    '$shedule_7',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_12', '$referee_6',   '$team_16', '7',    '$shedule_7',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_11', '$referee_7',   '$team_17', '7',    '$shedule_7',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_10', '$referee_8',   '$team_18', '7',    '$shedule_7',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_9',  '$referee_9',   '$team_19', '7',    '$shedule_7',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_14', '$referee_10',  '$team_20', '7',    '$shedule_7',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_4',  '$referee_11',  '$team_6',  '8',    '$shedule_8',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_3',  '$referee_12',  '$team_7',  '8',    '$shedule_8',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_2',  '$referee_13',  '$team_8',  '8',    '$shedule_8',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_1',  '$referee_14',  '$team_9',  '8',    '$shedule_8',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_19', '$referee_15',  '$team_10', '8',    '$shedule_8',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_18', '$referee_16',  '$team_11', '8',    '$shedule_8',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_17', '$referee_17',  '$team_12', '8',    '$shedule_8',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_16', '$referee_18',  '$team_13', '8',    '$shedule_8',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_15', '$referee_19',  '$team_14', '8',    '$shedule_8',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_20', '$referee_20',  '$team_5',  '8',    '$shedule_8',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_10', '$referee_21',  '$team_1',  '9',    '$shedule_9',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_9',  '$referee_22',  '$team_2',  '9',    '$shedule_9',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_8',  '$referee_23',  '$team_3',  '9',    '$shedule_9',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_7',  '$referee_24',  '$team_4',  '9',    '$shedule_9',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_6',  '$referee_25',  '$team_5',  '9',    '$shedule_9',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_14', '$referee_26',  '$team_16', '9',    '$shedule_9',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_13', '$referee_27',  '$team_17', '9',    '$shedule_9',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_12', '$referee_28',  '$team_18', '9',    '$shedule_9',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_11', '$referee_29',  '$team_19', '9',    '$shedule_9',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_15', '$referee_30',  '$team_20', '9',    '$shedule_9',   '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_5',  '$referee_1',   '$team_7',  '10',   '$shedule_10',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_4',  '$referee_2',   '$team_8',  '10',   '$shedule_10',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_3',  '$referee_3',   '$team_9',  '10',   '$shedule_10',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_2',  '$referee_4',   '$team_10', '10',   '$shedule_10',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_1',  '$referee_5',   '$team_11', '10',   '$shedule_10',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_19', '$referee_6',   '$team_12', '10',   '$shedule_10',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_18', '$referee_7',   '$team_13', '10',   '$shedule_10',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_17', '$referee_8',   '$team_14', '10',   '$shedule_10',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_16', '$referee_9',   '$team_15', '10',   '$shedule_10',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_20', '$referee_10',  '$team_6',  '10',   '$shedule_10',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_12', '$referee_11',  '$team_1',  '11',   '$shedule_11',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_11', '$referee_12',  '$team_2',  '11',   '$shedule_11',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_10', '$referee_13',  '$team_3',  '11',   '$shedule_11',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_9',  '$referee_14',  '$team_4',  '11',   '$shedule_11',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_8',  '$referee_15',  '$team_5',  '11',   '$shedule_11',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_7',  '$referee_16',  '$team_6',  '11',   '$shedule_11',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_15', '$referee_17',  '$team_17', '11',   '$shedule_11',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_14', '$referee_18',  '$team_18', '11',   '$shedule_11',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_13', '$referee_19',  '$team_19', '11',   '$shedule_11',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_16', '$referee_20',  '$team_20', '11',   '$shedule_11',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_6',  '$referee_21',  '$team_8',  '12',   '$shedule_12',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_5',  '$referee_22',  '$team_9',  '12',   '$shedule_12',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_4',  '$referee_23',  '$team_10', '12',   '$shedule_12',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_3',  '$referee_24',  '$team_11', '12',   '$shedule_12',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_2',  '$referee_25',  '$team_12', '12',   '$shedule_12',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_1',  '$referee_26',  '$team_13', '12',   '$shedule_12',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_19', '$referee_27',  '$team_14', '12',   '$shedule_12',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_18', '$referee_28',  '$team_15', '12',   '$shedule_12',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_17', '$referee_29',  '$team_16', '12',   '$shedule_12',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_20', '$referee_30',  '$team_7',  '12',   '$shedule_12',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_14', '$referee_1',   '$team_1',  '13',   '$shedule_13',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_13', '$referee_2',   '$team_2',  '13',   '$shedule_13',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_12', '$referee_3',   '$team_3',  '13',   '$shedule_13',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_11', '$referee_4',   '$team_4',  '13',   '$shedule_13',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_10', '$referee_5',   '$team_5',  '13',   '$shedule_13',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_9',  '$referee_6',   '$team_6',  '13',   '$shedule_13',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_8',  '$referee_7',   '$team_7',  '13',   '$shedule_13',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_16', '$referee_8',   '$team_18', '13',   '$shedule_13',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_15', '$referee_9',   '$team_19', '13',   '$shedule_13',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_17', '$referee_10',  '$team_20', '13',   '$shedule_13',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_7',  '$referee_11',  '$team_9',  '14',   '$shedule_14',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_6',  '$referee_12',  '$team_10', '14',   '$shedule_14',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_5',  '$referee_13',  '$team_11', '14',   '$shedule_14',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_4',  '$referee_14',  '$team_12', '14',   '$shedule_14',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_3',  '$referee_15',  '$team_13', '14',   '$shedule_14',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_2',  '$referee_16',  '$team_14', '14',   '$shedule_14',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_1',  '$referee_17',  '$team_15', '14',   '$shedule_14',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_19', '$referee_18',  '$team_16', '14',   '$shedule_14',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_18', '$referee_19',  '$team_17', '14',   '$shedule_14',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_20', '$referee_20',  '$team_8',  '14',   '$shedule_14',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_16', '$referee_21',  '$team_1',  '15',   '$shedule_15',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_15', '$referee_22',  '$team_2',  '15',   '$shedule_15',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_14', '$referee_23',  '$team_3',  '15',   '$shedule_15',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_13', '$referee_24',  '$team_4',  '15',   '$shedule_15',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_12', '$referee_25',  '$team_5',  '15',   '$shedule_15',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_11', '$referee_26',  '$team_6',  '15',   '$shedule_15',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_10', '$referee_27',  '$team_7',  '15',   '$shedule_15',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_9',  '$referee_28',  '$team_8',  '15',   '$shedule_15',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_17', '$referee_29',  '$team_19', '15',   '$shedule_15',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_18', '$referee_30',  '$team_20', '15',   '$shedule_15',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_8',  '$referee_1',   '$team_10', '16',   '$shedule_16',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_7',  '$referee_2',   '$team_11', '16',   '$shedule_16',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_6',  '$referee_3',   '$team_12', '16',   '$shedule_16',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_5',  '$referee_4',   '$team_13', '16',   '$shedule_16',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_4',  '$referee_5',   '$team_14', '16',   '$shedule_16',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_3',  '$referee_6',   '$team_15', '16',   '$shedule_16',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_2',  '$referee_7',   '$team_16', '16',   '$shedule_16',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_1',  '$referee_8',   '$team_17', '16',   '$shedule_16',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_19', '$referee_9',   '$team_18', '16',   '$shedule_16',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_20', '$referee_10',  '$team_9',  '16',   '$shedule_16',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_18', '$referee_11',  '$team_1',  '17',   '$shedule_17',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_17', '$referee_12',  '$team_2',  '17',   '$shedule_17',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_16', '$referee_13',  '$team_3',  '17',   '$shedule_17',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_15', '$referee_14',  '$team_4',  '17',   '$shedule_17',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_14', '$referee_15',  '$team_5',  '17',   '$shedule_17',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_13', '$referee_16',  '$team_6',  '17',   '$shedule_17',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_12', '$referee_17',  '$team_7',  '17',   '$shedule_17',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_11', '$referee_18',  '$team_8',  '17',   '$shedule_17',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_10', '$referee_19',  '$team_9',  '17',   '$shedule_17',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_19', '$referee_20',  '$team_20', '17',   '$shedule_17',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_9',  '$referee_21',  '$team_11', '18',   '$shedule_18',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_8',  '$referee_22',  '$team_12', '18',   '$shedule_18',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_7',  '$referee_23',  '$team_13', '18',   '$shedule_18',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_6',  '$referee_24',  '$team_14', '18',   '$shedule_18',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_5',  '$referee_25',  '$team_15', '18',   '$shedule_18',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_4',  '$referee_26',  '$team_16', '18',   '$shedule_18',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_3',  '$referee_27',  '$team_17', '18',   '$shedule_18',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_2',  '$referee_28',  '$team_18', '18',   '$shedule_18',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_1',  '$referee_29',  '$team_19', '18',   '$shedule_18',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_20', '$referee_30',  '$team_10', '18',   '$shedule_18',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_20', '$referee_1',   '$team_1',  '19',   '$shedule_19',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_19', '$referee_2',   '$team_2',  '19',   '$shedule_19',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_18', '$referee_3',   '$team_3',  '19',   '$shedule_19',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_17', '$referee_4',   '$team_4',  '19',   '$shedule_19',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_16', '$referee_5',   '$team_5',  '19',   '$shedule_19',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_15', '$referee_6',   '$team_6',  '19',   '$shedule_19',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_14', '$referee_7',   '$team_7',  '19',   '$shedule_19',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_13', '$referee_8',   '$team_8',  '19',   '$shedule_19',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_12', '$referee_9',   '$team_9',  '19',   '$shedule_19',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_11', '$referee_10',  '$team_10', '19',   '$shedule_19',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_1',  '$referee_11',  '$team_2',  '20',   '$shedule_20',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_12', '$referee_12',  '$team_10', '20',   '$shedule_20',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_13', '$referee_13',  '$team_9',  '20',   '$shedule_20',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_14', '$referee_14',  '$team_8',  '20',   '$shedule_20',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_15', '$referee_15',  '$team_7',  '20',   '$shedule_20',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_16', '$referee_16',  '$team_6',  '20',   '$shedule_20',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_17', '$referee_17',  '$team_5',  '20',   '$shedule_20',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_18', '$referee_18',  '$team_4',  '20',   '$shedule_20',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_19', '$referee_19',  '$team_3',  '20',   '$shedule_20',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_20', '$referee_20',  '$team_11', '20',   '$shedule_20',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_3',  '$referee_21',  '$team_1',  '21',   '$shedule_21',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_4',  '$referee_22',  '$team_19', '21',   '$shedule_21',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_5',  '$referee_23',  '$team_18', '21',   '$shedule_21',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_6',  '$referee_24',  '$team_17', '21',   '$shedule_21',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_7',  '$referee_25',  '$team_16', '21',   '$shedule_21',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_8',  '$referee_26',  '$team_15', '21',   '$shedule_21',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_9',  '$referee_27',  '$team_14', '21',   '$shedule_21',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_10', '$referee_28',  '$team_13', '21',   '$shedule_21',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_11', '$referee_29',  '$team_12', '21',   '$shedule_21',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_2',  '$referee_30',  '$team_20', '21',   '$shedule_21',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_1',  '$referee_1',   '$team_4',  '22',   '$shedule_22',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_2',  '$referee_2',   '$team_3',  '22',   '$shedule_22',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_13', '$referee_3',   '$team_11', '22',   '$shedule_22',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_14', '$referee_4',   '$team_10', '22',   '$shedule_22',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_15', '$referee_5',   '$team_9',  '22',   '$shedule_22',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_16', '$referee_6',   '$team_8',  '22',   '$shedule_22',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_17', '$referee_7',   '$team_7',  '22',   '$shedule_22',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_18', '$referee_8',   '$team_6',  '22',   '$shedule_22',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_19', '$referee_9',   '$team_5',  '22',   '$shedule_22',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_20', '$referee_10',  '$team_12', '22',   '$shedule_22',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_4',  '$referee_11',  '$team_2',  '23',   '$shedule_23',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_5',  '$referee_12',  '$team_1',  '23',   '$shedule_23',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_6',  '$referee_13',  '$team_19', '23',   '$shedule_23',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_7',  '$referee_14',  '$team_18', '23',   '$shedule_23',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_8',  '$referee_15',  '$team_17', '23',   '$shedule_23',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_9',  '$referee_16',  '$team_16', '23',   '$shedule_23',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_10', '$referee_17',  '$team_15', '23',   '$shedule_23',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_11', '$referee_18',  '$team_14', '23',   '$shedule_23',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_12', '$referee_19',  '$team_13', '23',   '$shedule_23',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_3',  '$referee_20',  '$team_20', '23',   '$shedule_23',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_1',  '$referee_21',  '$team_6',  '24',   '$shedule_24',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_2',  '$referee_22',  '$team_5',  '24',   '$shedule_24',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_3',  '$referee_23',  '$team_4',  '24',   '$shedule_24',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_14', '$referee_24',  '$team_12', '24',   '$shedule_24',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_15', '$referee_25',  '$team_11', '24',   '$shedule_24',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_16', '$referee_26',  '$team_10', '24',   '$shedule_24',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_17', '$referee_27',  '$team_9',  '24',   '$shedule_24',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_18', '$referee_28',  '$team_8',  '24',   '$shedule_24',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_19', '$referee_29',  '$team_7',  '24',   '$shedule_24',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_20', '$referee_30',  '$team_13', '24',   '$shedule_24',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_5',  '$referee_1',   '$team_3',  '25',   '$shedule_25',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_6',  '$referee_2',   '$team_2',  '25',   '$shedule_25',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_7',  '$referee_3',   '$team_1',  '25',   '$shedule_25',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_8',  '$referee_4',   '$team_19', '25',   '$shedule_25',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_9',  '$referee_5',   '$team_18', '25',   '$shedule_25',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_10', '$referee_6',   '$team_17', '25',   '$shedule_25',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_11', '$referee_7',   '$team_16', '25',   '$shedule_25',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_12', '$referee_8',   '$team_15', '25',   '$shedule_25',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_13', '$referee_9',   '$team_14', '25',   '$shedule_25',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_4',  '$referee_10',  '$team_20', '25',   '$shedule_25',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_1',  '$referee_11',  '$team_8',  '26',   '$shedule_26',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_2',  '$referee_12',  '$team_7',  '26',   '$shedule_26',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_3',  '$referee_13',  '$team_6',  '26',   '$shedule_26',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_4',  '$referee_14',  '$team_5',  '26',   '$shedule_26',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_15', '$referee_15',  '$team_13', '26',   '$shedule_26',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_16', '$referee_16',  '$team_12', '26',   '$shedule_26',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_17', '$referee_17',  '$team_11', '26',   '$shedule_26',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_18', '$referee_18',  '$team_10', '26',   '$shedule_26',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_19', '$referee_19',  '$team_9',  '26',   '$shedule_26',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_20', '$referee_20',  '$team_14', '26',   '$shedule_26',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_6',  '$referee_21',  '$team_4',  '27',   '$shedule_27',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_7',  '$referee_22',  '$team_3',  '27',   '$shedule_27',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_8',  '$referee_23',  '$team_2',  '27',   '$shedule_27',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_9',  '$referee_24',  '$team_1',  '27',   '$shedule_27',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_10', '$referee_25',  '$team_19', '27',   '$shedule_27',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_11', '$referee_26',  '$team_18', '27',   '$shedule_27',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_12', '$referee_27',  '$team_17', '27',   '$shedule_27',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_13', '$referee_28',  '$team_16', '27',   '$shedule_27',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_14', '$referee_29',  '$team_15', '27',   '$shedule_27',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_5',  '$referee_30',  '$team_20', '27',   '$shedule_27',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_1',  '$referee_1',   '$team_10', '28',   '$shedule_28',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_2',  '$referee_2',   '$team_9',  '28',   '$shedule_28',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_3',  '$referee_3',   '$team_8',  '28',   '$shedule_28',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_4',  '$referee_4',   '$team_7',  '28',   '$shedule_28',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_5',  '$referee_5',   '$team_6',  '28',   '$shedule_28',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_16', '$referee_6',   '$team_14', '28',   '$shedule_28',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_17', '$referee_7',   '$team_13', '28',   '$shedule_28',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_18', '$referee_8',   '$team_12', '28',   '$shedule_28',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_19', '$referee_9',   '$team_11', '28',   '$shedule_28',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_20', '$referee_10',  '$team_15', '28',   '$shedule_28',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_7',  '$referee_11',  '$team_5',  '29',   '$shedule_29',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_8',  '$referee_12',  '$team_4',  '29',   '$shedule_29',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_9',  '$referee_13',  '$team_3',  '29',   '$shedule_29',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_10', '$referee_14',  '$team_2',  '29',   '$shedule_29',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_11', '$referee_15',  '$team_1',  '29',   '$shedule_29',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_12', '$referee_16',  '$team_19', '29',   '$shedule_29',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_13', '$referee_17',  '$team_18', '29',   '$shedule_29',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_14', '$referee_18',  '$team_17', '29',   '$shedule_29',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_15', '$referee_19',  '$team_16', '29',   '$shedule_29',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_6',  '$referee_20',  '$team_20', '29',   '$shedule_29',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_1',  '$referee_21',  '$team_12', '30',   '$shedule_30',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_2',  '$referee_22',  '$team_11', '30',   '$shedule_30',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_3',  '$referee_23',  '$team_10', '30',   '$shedule_30',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_4',  '$referee_24',  '$team_9',  '30',   '$shedule_30',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_5',  '$referee_25',  '$team_8',  '30',   '$shedule_30',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_6',  '$referee_26',  '$team_7',  '30',   '$shedule_30',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_17', '$referee_27',  '$team_15', '30',   '$shedule_30',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_18', '$referee_28',  '$team_14', '30',   '$shedule_30',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_19', '$referee_29',  '$team_13', '30',   '$shedule_30',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_20', '$referee_30',  '$team_16', '30',   '$shedule_30',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_8',  '$referee_1',   '$team_6',  '31',   '$shedule_31',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_9',  '$referee_2',   '$team_5',  '31',   '$shedule_31',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_10', '$referee_3',   '$team_4',  '31',   '$shedule_31',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_11', '$referee_4',   '$team_3',  '31',   '$shedule_31',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_12', '$referee_5',   '$team_2',  '31',   '$shedule_31',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_13', '$referee_6',   '$team_1',  '31',   '$shedule_31',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_14', '$referee_7',   '$team_19', '31',   '$shedule_31',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_15', '$referee_8',   '$team_18', '31',   '$shedule_31',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_16', '$referee_9',   '$team_17', '31',   '$shedule_31',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_7',  '$referee_10',  '$team_20', '31',   '$shedule_31',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_1',  '$referee_11',  '$team_14', '32',   '$shedule_32',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_2',  '$referee_12',  '$team_13', '32',   '$shedule_32',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_3',  '$referee_13',  '$team_12', '32',   '$shedule_32',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_4',  '$referee_14',  '$team_11', '32',   '$shedule_32',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_5',  '$referee_15',  '$team_10', '32',   '$shedule_32',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_6',  '$referee_16',  '$team_9',  '32',   '$shedule_32',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_7',  '$referee_17',  '$team_8',  '32',   '$shedule_32',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_18', '$referee_18',  '$team_16', '32',   '$shedule_32',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_19', '$referee_19',  '$team_15', '32',   '$shedule_32',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_20', '$referee_20',  '$team_17', '32',   '$shedule_32',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_9',  '$referee_21',  '$team_7',  '33',   '$shedule_33',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_10', '$referee_22',  '$team_6',  '33',   '$shedule_33',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_11', '$referee_23',  '$team_5',  '33',   '$shedule_33',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_12', '$referee_24',  '$team_4',  '33',   '$shedule_33',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_13', '$referee_25',  '$team_3',  '33',   '$shedule_33',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_14', '$referee_26',  '$team_2',  '33',   '$shedule_33',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_15', '$referee_27',  '$team_1',  '33',   '$shedule_33',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_16', '$referee_28',  '$team_19', '33',   '$shedule_33',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_17', '$referee_29',  '$team_18', '33',   '$shedule_33',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_8',  '$referee_30',  '$team_20', '33',   '$shedule_33',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_1',  '$referee_1',   '$team_16', '34',   '$shedule_34',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_2',  '$referee_2',   '$team_15', '34',   '$shedule_34',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_3',  '$referee_3',   '$team_14', '34',   '$shedule_34',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_4',  '$referee_4',   '$team_13', '34',   '$shedule_34',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_5',  '$referee_5',   '$team_12', '34',   '$shedule_34',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_6',  '$referee_6',   '$team_11', '34',   '$shedule_34',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_7',  '$referee_7',   '$team_10', '34',   '$shedule_34',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_8',  '$referee_8',   '$team_9',  '34',   '$shedule_34',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_19', '$referee_9',   '$team_17', '34',   '$shedule_34',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_20', '$referee_10',  '$team_18', '34',   '$shedule_34',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_10', '$referee_11',  '$team_8',  '35',   '$shedule_35',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_11', '$referee_12',  '$team_7',  '35',   '$shedule_35',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_12', '$referee_13',  '$team_6',  '35',   '$shedule_35',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_13', '$referee_14',  '$team_5',  '35',   '$shedule_35',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_14', '$referee_15',  '$team_4',  '35',   '$shedule_35',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_15', '$referee_16',  '$team_3',  '35',   '$shedule_35',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_16', '$referee_17',  '$team_2',  '35',   '$shedule_35',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_17', '$referee_18',  '$team_1',  '35',   '$shedule_35',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_18', '$referee_19',  '$team_19', '35',   '$shedule_35',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_9',  '$referee_20',  '$team_20', '35',   '$shedule_35',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_1',  '$referee_21',  '$team_18', '36',   '$shedule_36',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_2',  '$referee_22',  '$team_17', '36',   '$shedule_36',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_3',  '$referee_23',  '$team_16', '36',   '$shedule_36',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_4',  '$referee_24',  '$team_15', '36',   '$shedule_36',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_5',  '$referee_25',  '$team_14', '36',   '$shedule_36',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_6',  '$referee_26',  '$team_13', '36',   '$shedule_36',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_7',  '$referee_27',  '$team_12', '36',   '$shedule_36',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_8',  '$referee_28',  '$team_11', '36',   '$shedule_36',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_10','$team_9',  '$referee_29',  '$team_10', '36',   '$shedule_36',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_20', '$referee_30',  '$team_19', '36',   '$shedule_36',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_9', '$team_11', '$referee_1',   '$team_9',  '37',   '$shedule_37',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_8', '$team_12', '$referee_2',   '$team_8',  '37',   '$shedule_37',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_7', '$team_13', '$referee_3',   '$team_7',  '37',   '$shedule_37',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_6', '$team_14', '$referee_4',   '$team_6',  '37',   '$shedule_37',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_5', '$team_15', '$referee_5',   '$team_5',  '37',   '$shedule_37',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_4', '$team_16', '$referee_6',   '$team_4',  '37',   '$shedule_37',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_3', '$team_17', '$referee_7',   '$team_3',  '37',   '$shedule_37',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_2', '$team_18', '$referee_8',   '$team_2',  '37',   '$shedule_37',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_1', '$team_19', '$referee_9',   '$team_1',  '37',   '$shedule_37',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_10', '$referee_10',  '$team_20', '37',   '$shedule_37',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_20','$team_1',  '$referee_11',  '$team_20', '38',   '$shedule_38',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_19','$team_2',  '$referee_12',  '$team_19', '38',   '$shedule_38',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_18','$team_3',  '$referee_13',  '$team_18', '38',   '$shedule_38',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_17','$team_4',  '$referee_14',  '$team_17', '38',   '$shedule_38',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_16','$team_5',  '$referee_15',  '$team_16', '38',   '$shedule_38',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_15','$team_6',  '$referee_16',  '$team_15', '38',   '$shedule_38',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_14','$team_7',  '$referee_17',  '$team_14', '38',   '$shedule_38',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_13','$team_8',  '$referee_18',  '$team_13', '38',   '$shedule_38',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_12','$team_9',  '$referee_19',  '$team_12', '38',   '$shedule_38',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3'),
                ('$team_11','$team_10', '$referee_20',  '$team_11', '38',   '$shedule_38',  '15'+RAND()*'15','$tournament_id','1'+RAND()*'3');";
    $mysqli->query($sql);
}

$sql = "SELECT `tournament_id`,
               `tournament_country_id`
        FROM `tournament`
        WHERE `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'
        ORDER BY `tournament_country_id` ASC";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;
$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_country; $i++)
{
    $country_id = $country_array[$i]['tournament_country_id'];

    $sql = "SELECT `referee_id`
            FROM `referee`
            WHERE `referee_country_id`='$country_id'
            ORDER BY `referee_reputation` DESC
            LIMIT 8";
    $referee_sql = $mysqli->query($sql);

    $count_referee = $referee_sql->num_rows;
    $referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

    for ($j=0; $j<$count_referee; $j++)
    {
        $referee  = 'referee_' . ($j + 1);
        $$referee = $referee_array[$j]['referee_id'];
    }

    $tournament_id  = $country_array[$i]['tournament_id'];

    $sql = "INSERT INTO `cupparticipant` (`cupparticipant_team_id`, `cupparticipant_tournament_id`, `cupparticipant_season_id`)
            SELECT `team_id`, '$tournament_id', '$igosja_season_id'
            FROM `team`
            LEFT JOIN `city`
            ON `team_city_id`=`city_id`
            WHERE `city_country_id`='$country_id'";
    $mysqli->query($sql);

    $sql = "SELECT `shedule_id`
            FROM `shedule`
            WHERE `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'
            ORDER BY `shedule_date` ASC
            LIMIT 2";
    $shedule_sql = $mysqli->query($sql);

    $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

    $shedule_id_1 = $shedule_array[0]['shedule_id'];
    $shedule_id_2 = $shedule_array[1]['shedule_id'];

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
        $team_1         = $team_array[$j]['cupparticipant_team_id'];
        $team_2         = $team_array[$j+1]['cupparticipant_team_id'];
        $referee_first  = 'referee_' . ($j + 1);
        $referee_second = 'referee_' . ($j + 2);
        $referee_id_1   = $$referee_first;
        $referee_id_2   = $$referee_second;

        $sql = "INSERT INTO `game`
                SET `game_guest_team_id`='$team_2',
                    `game_home_team_id`='$team_1',
                    `game_referee_id`='$referee_id_1',
                    `game_stadium_id`='$team_1',
                    `game_stage_id`='45',
                    `game_shedule_id`='$shedule_id_1',
                    `game_temperature`='15'+RAND()*'15',
                    `game_tournament_id`='$tournament_id',
                    `game_weather_id`='1'+RAND()*'3'";
        $mysqli->query($sql);

        $game_id = $mysqli->insert_id;

        $sql = "INSERT INTO `game`
                SET `game_first_game_id`='$game_id',
                    `game_guest_team_id`='$team_1',
                    `game_home_team_id`='$team_2',
                    `game_referee_id`='$referee_id_2',
                    `game_stadium_id`='$team_2',
                    `game_stage_id`='45',
                    `game_shedule_id`='$shedule_id_2',
                    `game_temperature`='15'+RAND()*'15',
                    `game_tournament_id`='$tournament_id',
                    `game_weather_id`='1'+RAND()*'3'";
        $mysqli->query($sql);
    }
}

print '<br/>Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br/>Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';