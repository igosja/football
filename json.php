<?php

include ('include/include.php');

$json_data = array();

if (isset($_GET['player_tactic_position_id']))
{
    $position_id = (int) $_GET['player_tactic_position_id'];

    $sql = "SELECT `position_name`
            FROM `position`
            WHERE `position_id`='$position_id'
            LIMIT 1";
    $position_sql = $mysqli->query($sql);

    $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `count_game`,
                   `lineup_position`,
                   `mark`,
                   `name_name`,
                   `player_id`,
                   `position_description`,
                   `role_description`,
                   `role_id`,
                   `surname_name`
            FROM `player`
            LEFT JOIN `name`
            ON `player_name_id`=`name_id`
            LEFT JOIN `surname`
            ON `player_surname_id`=`surname_id`
            LEFT JOIN `playerposition`
            ON `playerposition_player_id`=`player_id`
            LEFT JOIN `position`
            ON `position_id`=`playerposition_position_id`
            INNER JOIN
            (
                SELECT
                    IF ('$position_id'=`lineupcurrent_position_id_1`,  `lineupcurrent_player_id_1`,
                    IF ('$position_id'=`lineupcurrent_position_id_2`,  `lineupcurrent_player_id_2`,
                    IF ('$position_id'=`lineupcurrent_position_id_3`,  `lineupcurrent_player_id_3`,
                    IF ('$position_id'=`lineupcurrent_position_id_4`,  `lineupcurrent_player_id_4`,
                    IF ('$position_id'=`lineupcurrent_position_id_5`,  `lineupcurrent_player_id_5`,
                    IF ('$position_id'=`lineupcurrent_position_id_6`,  `lineupcurrent_player_id_6`,
                    IF ('$position_id'=`lineupcurrent_position_id_7`,  `lineupcurrent_player_id_7`,
                    IF ('$position_id'=`lineupcurrent_position_id_8`,  `lineupcurrent_player_id_8`,
                    IF ('$position_id'=`lineupcurrent_position_id_9`,  `lineupcurrent_player_id_9`,
                    IF ('$position_id'=`lineupcurrent_position_id_10`, `lineupcurrent_player_id_10`,
                    IF ('$position_id'=`lineupcurrent_position_id_11`, `lineupcurrent_player_id_11`,
                        0
                    ))))))))))) AS `lineup_player_id`,
                    IF ('$position_id'=`lineupcurrent_position_id_1`,  `lineupcurrent_role_id_1`,
                    IF ('$position_id'=`lineupcurrent_position_id_2`,  `lineupcurrent_role_id_2`,
                    IF ('$position_id'=`lineupcurrent_position_id_3`,  `lineupcurrent_role_id_3`,
                    IF ('$position_id'=`lineupcurrent_position_id_4`,  `lineupcurrent_role_id_4`,
                    IF ('$position_id'=`lineupcurrent_position_id_5`,  `lineupcurrent_role_id_5`,
                    IF ('$position_id'=`lineupcurrent_position_id_6`,  `lineupcurrent_role_id_6`,
                    IF ('$position_id'=`lineupcurrent_position_id_7`,  `lineupcurrent_role_id_7`,
                    IF ('$position_id'=`lineupcurrent_position_id_8`,  `lineupcurrent_role_id_8`,
                    IF ('$position_id'=`lineupcurrent_position_id_9`,  `lineupcurrent_role_id_9`,
                    IF ('$position_id'=`lineupcurrent_position_id_10`, `lineupcurrent_role_id_10`,
                    IF ('$position_id'=`lineupcurrent_position_id_11`, `lineupcurrent_role_id_11`,
                        0
                    ))))))))))) AS `lineup_role_id`,
                    IF ('$position_id'=`lineupcurrent_position_id_1`,  '1',
                    IF ('$position_id'=`lineupcurrent_position_id_2`,  '2',
                    IF ('$position_id'=`lineupcurrent_position_id_3`,  '3',
                    IF ('$position_id'=`lineupcurrent_position_id_4`,  '4',
                    IF ('$position_id'=`lineupcurrent_position_id_5`,  '5',
                    IF ('$position_id'=`lineupcurrent_position_id_6`,  '6',
                    IF ('$position_id'=`lineupcurrent_position_id_7`,  '7',
                    IF ('$position_id'=`lineupcurrent_position_id_8`,  '8',
                    IF ('$position_id'=`lineupcurrent_position_id_9`,  '9',
                    IF ('$position_id'=`lineupcurrent_position_id_10`, '10',
                    IF ('$position_id'=`lineupcurrent_position_id_11`, '11',
                        0
                    ))))))))))) AS `lineup_position`
                FROM `lineupcurrent`
                WHERE `lineupcurrent_team_id`='$authorization_team_id'
                LIMIT 1
            ) AS `t1`
            ON `lineup_player_id`=`player_id`
            LEFT JOIN `role`
            ON `lineup_role_id`=`role_id`
            LEFT JOIN
            (
                SELECT SUM(`statisticplayer_game`) AS `count_game`,
                       ROUND(SUM(`statisticplayer_mark`)/SUM(`statisticplayer_game`),2) AS `mark`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_season_id`='$igosja_season_id'
                GROUP BY `statisticplayer_player_id`
            ) AS `t2`
            ON `player_id`=`statisticplayer_player_id`
            WHERE `playerposition_value`='100'
            LIMIT 1";
    $lineup_sql = $mysqli->query($sql);

    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `role_id`,
                   `role_name`
            FROM `positionrole`
            LEFT JOIN `role`
            ON `role_id`=`positionrole_role_id`
            WHERE `positionrole_position_id`='$position_id'
            ORDER BY `positionrole_id` ASC";
    $role_sql = $mysqli->query($sql);

    $role_array = $role_sql->fetch_all(MYSQLI_ASSOC);

    $json_data['position_name']         = $position_array[0]['position_name'];
    $json_data['position_description']  = $lineup_array[0]['position_description'];
    $json_data['player_name']           = $lineup_array[0]['name_name'] . ' ' . $lineup_array[0]['surname_name'];
    $json_data['role_id']               = $lineup_array[0]['role_id'];
    $json_data['role_description']      = $lineup_array[0]['role_description'];
    $json_data['game']                  = $lineup_array[0]['count_game'];
    $json_data['mark']                  = $lineup_array[0]['mark'];
    $json_data['position']              = $lineup_array[0]['lineup_position'];
    $json_data['role_array']            = $role_array;
}
elseif (isset($_GET['player_tactic_position_id_national']))
{
    $position_id = (int) $_GET['player_tactic_position_id_national'];

    $sql = "SELECT `position_name`
            FROM `position`
            WHERE `position_id`='$position_id'
            LIMIT 1";
    $position_sql = $mysqli->query($sql);

    $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `count_game`,
                   `lineup_position`,
                   `mark`,
                   `name_name`,
                   `player_id`,
                   `position_description`,
                   `role_description`,
                   `role_id`,
                   `surname_name`
            FROM `player`
            LEFT JOIN `name`
            ON `player_name_id`=`name_id`
            LEFT JOIN `surname`
            ON `player_surname_id`=`surname_id`
            LEFT JOIN `playerposition`
            ON `playerposition_player_id`=`player_id`
            LEFT JOIN `position`
            ON `position_id`=`playerposition_position_id`
            INNER JOIN
            (
                SELECT
                    IF ('$position_id'=`lineupcurrent_position_id_1`,  `lineupcurrent_player_id_1`,
                    IF ('$position_id'=`lineupcurrent_position_id_2`,  `lineupcurrent_player_id_2`,
                    IF ('$position_id'=`lineupcurrent_position_id_3`,  `lineupcurrent_player_id_3`,
                    IF ('$position_id'=`lineupcurrent_position_id_4`,  `lineupcurrent_player_id_4`,
                    IF ('$position_id'=`lineupcurrent_position_id_5`,  `lineupcurrent_player_id_5`,
                    IF ('$position_id'=`lineupcurrent_position_id_6`,  `lineupcurrent_player_id_6`,
                    IF ('$position_id'=`lineupcurrent_position_id_7`,  `lineupcurrent_player_id_7`,
                    IF ('$position_id'=`lineupcurrent_position_id_8`,  `lineupcurrent_player_id_8`,
                    IF ('$position_id'=`lineupcurrent_position_id_9`,  `lineupcurrent_player_id_9`,
                    IF ('$position_id'=`lineupcurrent_position_id_10`, `lineupcurrent_player_id_10`,
                    IF ('$position_id'=`lineupcurrent_position_id_11`, `lineupcurrent_player_id_11`,
                        0
                    ))))))))))) AS `lineup_player_id`,
                    IF ('$position_id'=`lineupcurrent_position_id_1`,  `lineupcurrent_role_id_1`,
                    IF ('$position_id'=`lineupcurrent_position_id_2`,  `lineupcurrent_role_id_2`,
                    IF ('$position_id'=`lineupcurrent_position_id_3`,  `lineupcurrent_role_id_3`,
                    IF ('$position_id'=`lineupcurrent_position_id_4`,  `lineupcurrent_role_id_4`,
                    IF ('$position_id'=`lineupcurrent_position_id_5`,  `lineupcurrent_role_id_5`,
                    IF ('$position_id'=`lineupcurrent_position_id_6`,  `lineupcurrent_role_id_6`,
                    IF ('$position_id'=`lineupcurrent_position_id_7`,  `lineupcurrent_role_id_7`,
                    IF ('$position_id'=`lineupcurrent_position_id_8`,  `lineupcurrent_role_id_8`,
                    IF ('$position_id'=`lineupcurrent_position_id_9`,  `lineupcurrent_role_id_9`,
                    IF ('$position_id'=`lineupcurrent_position_id_10`, `lineupcurrent_role_id_10`,
                    IF ('$position_id'=`lineupcurrent_position_id_11`, `lineupcurrent_role_id_11`,
                        0
                    ))))))))))) AS `lineup_role_id`,
                    IF ('$position_id'=`lineupcurrent_position_id_1`,  '1',
                    IF ('$position_id'=`lineupcurrent_position_id_2`,  '2',
                    IF ('$position_id'=`lineupcurrent_position_id_3`,  '3',
                    IF ('$position_id'=`lineupcurrent_position_id_4`,  '4',
                    IF ('$position_id'=`lineupcurrent_position_id_5`,  '5',
                    IF ('$position_id'=`lineupcurrent_position_id_6`,  '6',
                    IF ('$position_id'=`lineupcurrent_position_id_7`,  '7',
                    IF ('$position_id'=`lineupcurrent_position_id_8`,  '8',
                    IF ('$position_id'=`lineupcurrent_position_id_9`,  '9',
                    IF ('$position_id'=`lineupcurrent_position_id_10`, '10',
                    IF ('$position_id'=`lineupcurrent_position_id_11`, '11',
                        0
                    ))))))))))) AS `lineup_position`
                FROM `lineupcurrent`
                WHERE `lineupcurrent_country_id`='$authorization_country_id'
                LIMIT 1
            ) AS `t1`
            ON `lineup_player_id`=`player_id`
            LEFT JOIN `role`
            ON `lineup_role_id`=`role_id`
            LEFT JOIN
            (
                SELECT SUM(`statisticplayer_game`) AS `count_game`,
                       ROUND(SUM(`statisticplayer_mark`)/SUM(`statisticplayer_game`),2) AS `mark`,
                       `statisticplayer_player_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_season_id`='$igosja_season_id'
                GROUP BY `statisticplayer_player_id`
            ) AS `t2`
            ON `player_id`=`statisticplayer_player_id`
            WHERE `playerposition_value`='100'
            LIMIT 1";
    $lineup_sql = $mysqli->query($sql);

    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `role_id`,
                   `role_name`
            FROM `positionrole`
            LEFT JOIN `role`
            ON `role_id`=`positionrole_role_id`
            WHERE `positionrole_position_id`='$position_id'
            ORDER BY `positionrole_id` ASC";
    $role_sql = $mysqli->query($sql);

    $role_array = $role_sql->fetch_all(MYSQLI_ASSOC);

    $json_data['position_name']         = $position_array[0]['position_name'];
    $json_data['position_description']  = $lineup_array[0]['position_description'];
    $json_data['player_name']           = $lineup_array[0]['name_name'] . ' ' . $lineup_array[0]['surname_name'];
    $json_data['role_id']               = $lineup_array[0]['role_id'];
    $json_data['role_description']      = $lineup_array[0]['role_description'];
    $json_data['game']                  = $lineup_array[0]['count_game'];
    $json_data['mark']                  = $lineup_array[0]['mark'];
    $json_data['position']              = $lineup_array[0]['lineup_position'];
    $json_data['role_array']            = $role_array;
}
elseif (isset($_GET['select_value']))
{
    $value      = (int) $_GET['select_value'];
    $give       = $_GET['select_give'];
    $need       = $_GET['select_need'];
    $need_id    = $need . '_id';
    $need_name  = $need . '_name';

    $sql = "SELECT `" . $need . "_id`,
                   `" . $need . "_name`
            FROM `" . $need . "`
            WHERE `" . $need . "_" . $give . "_id`='$value'";
    $result_sql = $mysqli->query($sql);

    $count_result = $result_sql->num_rows;
    $result_array = $result_sql->fetch_all(MYSQLI_ASSOC);

    $select_array = array();

    for ($i=0; $i<$count_result; $i++)
    {
        $select_array[$i]['value'] = $result_array[$i][$need . '_id'];
        $select_array[$i]['text']  = $result_array[$i][$need . '_name'];
    }

    $json_data['select_array'] = $select_array;
}
elseif (isset($_GET['shedule_prev']))
{
    $shedule_id     = (int) $_GET['shedule_prev'];
    $tournament_id  = (int) $_GET['tournament'];

    $sql = "SELECT `game_id`,
                   `game_guest_score`,
                   `game_guest_team_id`,
                   `game_home_score`,
                   `game_home_team_id`,
                   `game_played`,
                   `guest_team`.`team_name` AS `guest_team_name`,
                   `home_team`.`team_name` AS `home_team_name`,
                   `shedule_date`,
                   DATE_FORMAT(`shedule_date`,'%W') AS `shedule_day`,
                   `shedule_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `team` AS `home_team`
            ON `home_team`.`team_id`=`game_home_team_id`
            LEFT JOIN `team` AS `guest_team`
            ON `guest_team`.`team_id`=`game_guest_team_id`
            WHERE `game_tournament_id`='$tournament_id'
            AND `shedule_season_id`='$igosja_season_id'
            AND `shedule_date`=
            (
                SELECT `shedule_date`
                FROM `shedule`
                LEFT JOIN `game`
                ON `game_shedule_id`=`shedule_id`
                WHERE `shedule_id`<'$shedule_id'
                AND `game_tournament_id`='$tournament_id'
                AND `shedule_season_id`='$igosja_season_id'
                ORDER BY `shedule_date` DESC
                LIMIT 1
            )
            ORDER BY `game_id` ASC";
    $result_sql = $mysqli->query($sql);

    $count_result = $result_sql->num_rows;
    $result_array = $result_sql->fetch_all(MYSQLI_ASSOC);

    $game_array = array();

    for ($i=0; $i<$count_result; $i++)
    {
        $game_array[$i]['game_id']              = $result_array[$i]['game_id'];
        $game_array[$i]['game_guest_score']     = $result_array[$i]['game_guest_score'];
        $game_array[$i]['game_guest_team_id']   = $result_array[$i]['game_guest_team_id'];
        $game_array[$i]['game_home_score']      = $result_array[$i]['game_home_score'];
        $game_array[$i]['game_home_team_id']    = $result_array[$i]['game_home_team_id'];
        $game_array[$i]['game_played']          = $result_array[$i]['game_played'];
        $game_array[$i]['guest_team_name']      = $result_array[$i]['guest_team_name'];
        $game_array[$i]['home_team_name']       = $result_array[$i]['home_team_name'];
        $game_array[$i]['shedule_day']          = $result_array[$i]['shedule_day'];
        $game_array[$i]['shedule_date']         = date('d.m.Y', strtotime($result_array[$i]['shedule_date']));
        $game_array[$i]['shedule_id']           = $result_array[$i]['shedule_id'];
    }

    $json_data['game_array'] = $game_array;
}
elseif (isset($_GET['shedule_next']))
{
    $shedule_id     = (int) $_GET['shedule_next'];
    $tournament_id  = (int) $_GET['tournament'];

    $sql = "SELECT `game_id`,
                   `game_guest_score`,
                   `game_guest_team_id`,
                   `game_home_score`,
                   `game_home_team_id`,
                   `game_played`,
                   `guest_team`.`team_name` AS `guest_team_name`,
                   `home_team`.`team_name` AS `home_team_name`,
                   `shedule_date`,
                   DATE_FORMAT(`shedule_date`,'%W') AS `shedule_day`,
                   `shedule_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `team` AS `home_team`
            ON `home_team`.`team_id`=`game_home_team_id`
            LEFT JOIN `team` AS `guest_team`
            ON `guest_team`.`team_id`=`game_guest_team_id`
            WHERE `game_tournament_id`='$tournament_id'
            AND `shedule_season_id`='$igosja_season_id'
            AND `shedule_date`=
            (
                SELECT `shedule_date`
                FROM `shedule`
                LEFT JOIN `game`
                ON `game_shedule_id`=`shedule_id`
                WHERE `shedule_id`>'$shedule_id'
                AND `game_tournament_id`='$tournament_id'
                AND `shedule_season_id`='$igosja_season_id'
                ORDER BY `shedule_date` ASC
                LIMIT 1
            )
            ORDER BY `game_id` ASC";
    $result_sql = $mysqli->query($sql);

    $count_result = $result_sql->num_rows;
    $result_array = $result_sql->fetch_all(MYSQLI_ASSOC);

    $game_array = array();

    for ($i=0; $i<$count_result; $i++)
    {
        $game_array[$i]['game_id']              = $result_array[$i]['game_id'];
        $game_array[$i]['game_guest_score']     = $result_array[$i]['game_guest_score'];
        $game_array[$i]['game_guest_team_id']   = $result_array[$i]['game_guest_team_id'];
        $game_array[$i]['game_home_score']      = $result_array[$i]['game_home_score'];
        $game_array[$i]['game_home_team_id']    = $result_array[$i]['game_home_team_id'];
        $game_array[$i]['game_played']          = $result_array[$i]['game_played'];
        $game_array[$i]['guest_team_name']      = $result_array[$i]['guest_team_name'];
        $game_array[$i]['home_team_name']       = $result_array[$i]['home_team_name'];
        $game_array[$i]['shedule_day']          = $result_array[$i]['shedule_day'];
        $game_array[$i]['shedule_date']         = date('d.m.Y', strtotime($result_array[$i]['shedule_date']));
        $game_array[$i]['shedule_id']           = $result_array[$i]['shedule_id'];
    }

    $json_data['game_array'] = $game_array;
}
elseif (isset($_GET['statustransfer_id']))
{
    $statustransfer_id  = (int) $_GET['statustransfer_id'];
    $player_id          = (int) $_GET['player_id'];

    $sql = "UPDATE `player`
            SET `player_statustransfer_id`='$statustransfer_id'
            WHERE `player_id`='$player_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['statusrent_id']))
{
    $statusrent_id  = (int) $_GET['statusrent_id'];
    $player_id      = (int) $_GET['player_id'];

    $sql = "UPDATE `player`
            SET `player_statusrent_id`='$statusrent_id'
            WHERE `player_id`='$player_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['statusteam_id']))
{
    $statusteam_id  = (int) $_GET['statusteam_id'];
    $player_id      = (int) $_GET['player_id'];

    $sql = "UPDATE `player`
            SET `player_statusteam_id`='$statusteam_id'
            WHERE `player_id`='$player_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['statusnational_id']))
{
    $statusnational_id  = (int) $_GET['statusnational_id'];
    $player_id          = (int) $_GET['player_id'];

    $sql = "UPDATE `player`
            SET `player_statusnational_id`='$statusnational_id'
            WHERE `player_id`='$player_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['transfer_price']))
{
    $transfer_price = (int) $_GET['transfer_price'];
    $player_id      = (int) $_GET['player_id'];

    $sql = "UPDATE `player`
            SET `player_transfer_price`='$transfer_price'
            WHERE `player_id`='$player_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['number']))
{
    $number    = (int) $_GET['number'];
    $player_id = (int) $_GET['player_id'];

    $sql = "UPDATE `player`
            SET `player_number`='$number'
            WHERE `player_id`='$player_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['number_national']))
{
    $number    = (int) $_GET['number_national'];
    $player_id = (int) $_GET['player_id'];

    $sql = "UPDATE `player`
            SET `player_number_national`='$number'
            WHERE `player_id`='$player_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['offer_price']))
{
    $offer_price    = (int) $_GET['offer_price'];
    $offer_type     = (int) $_GET['offer_type'];
    $offer_period   = (int) $_GET['offer_period'];
    $player_id      = (int) $_GET['player_id'];

    $sql = "SELECT `playeroffer_id`
            FROM `playeroffer`
            WHERE `playeroffer_player_id`='$player_id'
            AND `playeroffer_team_id`='$authorization_team_id'
            AND `playeroffer_offertype_id`='$offer_type'
            LIMIT 1";
    $check_sql = $mysqli->query($sql);

    $count_check = $check_sql->num_rows;

    if (0 == $count_check)
    {
        $sql = "INSERT INTO `playeroffer`
                SET `playeroffer_player_id`='$player_id',
                    `playeroffer_offertype_id`='$offer_type',
                    `playeroffer_period`='$offer_period',
                    `playeroffer_price`='$offer_price',
                    `playeroffer_team_id`='$authorization_team_id',
                    `playeroffer_date`=SYSDATE()";
        $mysqli->query($sql);
    }
    else
    {
        $sql = "UPDATE `playeroffer`
                SET `playeroffer_offertype_id`='$offer_type',
                    `playeroffer_period`='$offer_period',
                    `playeroffer_price`='$offer_price',
                    `playeroffer_date`=SYSDATE()
                WHERE `playeroffer_player_id`='$player_id'
                AND `playeroffer_team_id`='$authorization_team_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $json_data['success'] = 1;
}
elseif (isset($_GET['news_id']))
{
    $news_id = (int) $_GET['news_id'];

    $sql = "SELECT `news_text`,
                   `news_title`
            FROM `news`
            WHERE `news_id`='$news_id'
            LIMIT 1";
    $news_sql = $mysqli->query($sql);

    $news_array = $news_sql->fetch_all(MYSQLI_ASSOC);

    $json_data['news_array'] = $news_array;
}
elseif (isset($_GET['note_id']))
{
    $note_id = (int) $_GET['note_id'];

    $sql = "SELECT `note_text`,
                   `note_title`
            FROM `note`
            WHERE `note_id`='$note_id'
            LIMIT 1";
    $note_sql = $mysqli->query($sql);

    $note_array = $note_sql->fetch_all(MYSQLI_ASSOC);

    $json_data['note_array'] = $note_array;
}
elseif (isset($_GET['style_id']))
{
    $style_id = (int) $_GET['style_id'];

    $sql = "UPDATE `lineupcurrent`
            SET `lineupcurrent_gamestyle_id`='$style_id'
            WHERE `lineupcurrent_team_id`='$authorization_team_id'
            LIMIT 1";
    $mysqli->query($sql);

    $sql = "SELECT `gamestyle_description`,
                   `gamestyle_name`
            FROM `gamestyle`
            WHERE `gamestyle_id`='$style_id'
            LIMIT 1";
    $gamestyle_sql = $mysqli->query($sql);

    $gamestyle_array = $gamestyle_sql->fetch_all(MYSQLI_ASSOC);

    $json_data['gamestyle_array'] = $gamestyle_array;
}
elseif (isset($_GET['national_style_id']))
{
    $style_id = (int) $_GET['national_style_id'];

    $sql = "UPDATE `lineupcurrent`
            SET `lineupcurrent_gamestyle_id`='$style_id'
            WHERE `lineupcurrent_country_id`='$authorization_country_id'
            LIMIT 1";
    $mysqli->query($sql);

    $sql = "SELECT `gamestyle_description`,
                   `gamestyle_name`
            FROM `gamestyle`
            WHERE `gamestyle_id`='$style_id'
            LIMIT 1";
    $gamestyle_sql = $mysqli->query($sql);

    $gamestyle_array = $gamestyle_sql->fetch_all(MYSQLI_ASSOC);

    $json_data['gamestyle_array'] = $gamestyle_array;
}
elseif (isset($_GET['mood_id']))
{
    $mood_id = (int) $_GET['mood_id'];

    $sql = "UPDATE `lineupcurrent`
            SET `lineupcurrent_gamemood_id`='$mood_id'
            WHERE `lineupcurrent_team_id`='$authorization_team_id'
            LIMIT 1";
    $mysqli->query($sql);

    $sql = "SELECT `gamemood_description`,
                   `gamemood_name`
            FROM `gamemood`
            WHERE `gamemood_id`='$mood_id'
            LIMIT 1";
    $gamemood_sql = $mysqli->query($sql);

    $gamemood_array = $gamemood_sql->fetch_all(MYSQLI_ASSOC);

    $json_data['gamemood_array'] = $gamemood_array;
}
elseif (isset($_GET['national_mood_id']))
{
    $mood_id = (int) $_GET['national_mood_id'];

    $sql = "UPDATE `lineupcurrent`
            SET `lineupcurrent_gamemood_id`='$mood_id'
            WHERE `lineupcurrent_country_id`='$authorization_country_id'
            LIMIT 1";
    $mysqli->query($sql);

    $sql = "SELECT `gamemood_description`,
                   `gamemood_name`
            FROM `gamemood`
            WHERE `gamemood_id`='$mood_id'
            LIMIT 1";
    $gamemood_sql = $mysqli->query($sql);

    $gamemood_array = $gamemood_sql->fetch_all(MYSQLI_ASSOC);

    $json_data['gamemood_array'] = $gamemood_array;
}
elseif (isset($_GET['penalty_id']))
{
    $penalty_id = (int) $_GET['penalty_id'];
    $player_id  = (int) $_GET['player_id'];

    $sql = "UPDATE `team`
            SET `team_penalty_player_id_" . $penalty_id . "`='$player_id'
            WHERE `team_id`='$authorization_team_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['penalty_id_national']))
{
    $penalty_id = (int) $_GET['penalty_id_national'];
    $player_id  = (int) $_GET['player_id'];

    $sql = "UPDATE `country`
            SET `country_penalty_player_id_" . $penalty_id . "`='$player_id'
            WHERE `country_id`='$authorization_country_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['captain_id']))
{
    $captain_id = (int) $_GET['captain_id'];
    $player_id  = (int) $_GET['player_id'];

    $sql = "UPDATE `team`
            SET `team_captain_player_id_" . $captain_id . "`='$player_id'
            WHERE `team_id`='$authorization_team_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['captain_id_national']))
{
    $captain_id = (int) $_GET['captain_id_national'];
    $player_id  = (int) $_GET['player_id'];

    $sql = "UPDATE `country`
            SET `country_captain_player_id_" . $captain_id . "`='$player_id'
            WHERE `country_id`='$authorization_country_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['corner_left']))
{
    $corner_left = (int) $_GET['corner_left'];
    $player_id   = (int) $_GET['player_id'];

    $sql = "UPDATE `team`
            SET `team_corner_left_player_id_" . $corner_left . "`='$player_id'
            WHERE `team_id`='$authorization_team_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['corner_left_national']))
{
    $corner_left = (int) $_GET['corner_left_national'];
    $player_id   = (int) $_GET['player_id'];

    $sql = "UPDATE `country`
            SET `country_corner_left_player_id_" . $corner_left . "`='$player_id'
            WHERE `country_id`='$authorization_country_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['corner_right']))
{
    $corner_right = (int) $_GET['corner_right'];
    $player_id    = (int) $_GET['player_id'];

    $sql = "UPDATE `team`
            SET `team_corner_right_player_id_" . $corner_right . "`='$player_id'
            WHERE `team_id`='$authorization_team_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['corner_right_national']))
{
    $corner_right = (int) $_GET['corner_right_national'];
    $player_id    = (int) $_GET['player_id'];

    $sql = "UPDATE `country`
            SET `country_corner_right_player_id_" . $corner_right . "`='$player_id'
            WHERE `country_id`='$authorization_country_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['freekick_left']))
{
    $freekick_left = (int) $_GET['freekick_left'];
    $player_id     = (int) $_GET['player_id'];

    $sql = "UPDATE `team`
            SET `team_freekick_left_player_id_" . $freekick_left . "`='$player_id'
            WHERE `team_id`='$authorization_team_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['freekick_left_national']))
{
    $freekick_left = (int) $_GET['freekick_left_national'];
    $player_id     = (int) $_GET['player_id'];

    $sql = "UPDATE `country`
            SET `country_freekick_left_player_id_" . $freekick_left . "`='$player_id'
            WHERE `country_id`='$authorization_country_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['freekick_right']))
{
    $freekick_right = (int) $_GET['freekick_right'];
    $player_id      = (int) $_GET['player_id'];

    $sql = "UPDATE `team`
            SET `team_freekick_right_player_id_" . $freekick_right . "`='$player_id'
            WHERE `team_id`='$authorization_team_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['freekick_right_national']))
{
    $freekick_right = (int) $_GET['freekick_right_national'];
    $player_id      = (int) $_GET['player_id'];

    $sql = "UPDATE `country`
            SET `country_freekick_right_player_id_" . $freekick_right . "`='$player_id'
            WHERE `country_id`='$authorization_country_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['out_left']))
{
    $out_left  = (int) $_GET['out_left'];
    $player_id = (int) $_GET['player_id'];

    $sql = "UPDATE `team`
            SET `team_out_left_player_id_" . $out_left . "`='$player_id'
            WHERE `team_id`='$authorization_team_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['out_left_national']))
{
    $out_left  = (int) $_GET['out_left_national'];
    $player_id = (int) $_GET['player_id'];

    $sql = "UPDATE `country`
            SET `country_out_left_player_id_" . $out_left . "`='$player_id'
            WHERE `country_id`='$authorization_country_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['out_right']))
{
    $out_right = (int) $_GET['out_right'];
    $player_id = (int) $_GET['player_id'];

    $sql = "UPDATE `team`
            SET `team_out_right_player_id_" . $out_right . "`='$player_id'
            WHERE `team_id`='$authorization_team_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['out_right_national']))
{
    $out_right = (int) $_GET['out_right_national'];
    $player_id = (int) $_GET['player_id'];

    $sql = "UPDATE `country`
            SET `country_out_right_player_id_" . $out_right . "`='$player_id'
            WHERE `country_id`='$authorization_country_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['training_position_id']))
{
    $position_id = (int) $_GET['training_position_id'];
    $player_id   = (int) $_GET['player_id'];

    $sql = "UPDATE `player`
            SET `player_training_position_id`='$position_id'
            WHERE `player_id`='$player_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['training_attribute_id']))
{
    $attribute_id = (int) $_GET['training_attribute_id'];
    $player_id    = (int) $_GET['player_id'];

    $sql = "UPDATE `player`
            SET `player_training_attribute_id`='$attribute_id'
            WHERE `player_id`='$player_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['training_intensity']))
{
    $intensity = (int) $_GET['training_intensity'];
    $player_id = (int) $_GET['player_id'];

    $sql = "UPDATE `player`
            SET `player_training_intensity`='$intensity'
            WHERE `player_id`='$player_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['instruction_id']))
{
    $instruction_id = (int) $_GET['instruction_id'];

    $sql = "SELECT `teaminstruction_id`,
                   `teaminstruction_status`
            FROM `teaminstruction`
            WHERE `teaminstruction_team_id`='$authorization_team_id'
            AND `teaminstruction_instruction_id`='$instruction_id'
            LIMIT 1";
    $teaminstruction_sql = $mysqli->query($sql);

    $count_teaminstruction = $teaminstruction_sql->num_rows;

    if (0 == $count_teaminstruction)
    {
        $sql = "INSERT INTO `teaminstruction`
                SET `teaminstruction_team_id`='$authorization_team_id',
                    `teaminstruction_instruction_id`='$instruction_id'";
        $mysqli->query($sql);
    }
    else
    {
        $teaminstruction_array = $teaminstruction_sql->fetch_all(MYSQLI_ASSOC);

        $teaminstruction_id     = $teaminstruction_array[0]['teaminstruction_id'];
        $teaminstruction_status = $teaminstruction_array[0]['teaminstruction_status'];

        if (0 == $teaminstruction_status)
        {
            $teaminstruction_status = 1;
        }
        else
        {
            $teaminstruction_status = 0;
        }

        $sql = "UPDATE `teaminstruction`
                SET `teaminstruction_status`='$teaminstruction_status'
                WHERE `teaminstruction_id`='$teaminstruction_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $json_data['success'] = 1;
}
elseif (isset($_GET['national_instruction_id']))
{
    $instruction_id = (int) $_GET['national_instruction_id'];

    $sql = "SELECT `teaminstruction_id`,
                   `teaminstruction_status`
            FROM `teaminstruction`
            WHERE `teaminstruction_country_id`='$authorization_country_id'
            AND `teaminstruction_instruction_id`='$instruction_id'
            LIMIT 1";
    $teaminstruction_sql = $mysqli->query($sql);

    $count_teaminstruction = $teaminstruction_sql->num_rows;

    if (0 == $count_teaminstruction)
    {
        $sql = "INSERT INTO `teaminstruction`
                SET `teaminstruction_country_id`='$authorization_country_id',
                    `teaminstruction_instruction_id`='$instruction_id'";
        $mysqli->query($sql);
    }
    else
    {
        $teaminstruction_array = $teaminstruction_sql->fetch_all(MYSQLI_ASSOC);

        $teaminstruction_id     = $teaminstruction_array[0]['teaminstruction_id'];
        $teaminstruction_status = $teaminstruction_array[0]['teaminstruction_status'];

        if (0 == $teaminstruction_status)
        {
            $teaminstruction_status = 1;
        }
        else
        {
            $teaminstruction_status = 0;
        }

        $sql = "UPDATE `teaminstruction`
                SET `teaminstruction_status`='$teaminstruction_status'
                WHERE `teaminstruction_id`='$teaminstruction_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $json_data['success'] = 1;
}
elseif (isset($_GET['asktoplay']))
{
    $shedule_id  = (int) $_GET['asktoplay'];

    if (isset($_GET['delete']))
    {
        $delete = (int) $_GET['delete'];

        $sql = "SELECT COUNT(`asktoplay_id`) AS `count`
                FROM `asktoplay`
                WHERE `asktoplay_shedule_id`='$shedule_id'
                AND `asktoplay_id`='$delete'
                AND (`asktoplay_invitee_team_id`='$authorization_team_id'
                OR `asktoplay_inviter_team_id`='$authorization_team_id')";
        $check_sql = $mysqli->query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);
        $count_check = $check_array[0]['count'];

        if (0 != $count_check)
        {
            $sql = "DELETE FROM `asktoplay`
                    WHERE `asktoplay_id`='$delete'";
            $mysqli->query($sql);
        }
    }
    elseif (isset($_GET['invite']))
    {
        $invite = (int) $_GET['invite'];
        $home   = (int) $_GET['home'];

        $sql = "SELECT COUNT(`game_id`) AS `count`
                FROM `game`
                WHERE `game_shedule_id`='$shedule_id'
                AND (`game_home_team_id`='$authorization_team_id'
                OR `game_guest_team_id`='$authorization_team_id')";
        $check_sql = $mysqli->query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);
        $count_check = $check_array[0]['count'];

        if (0 == $count_check)
        {
            $sql = "INSERT INTO `asktoplay`
                    SET `asktoplay_invitee_team_id`='$invite',
                        `asktoplay_inviter_team_id`='$authorization_team_id',
                        `asktoplay_home`='$home',
                        `asktoplay_shedule_id`='$shedule_id'";
            $mysqli->query($sql);
        }
    }

    $sql = "SELECT `shedule_date`
            FROM `shedule`
            WHERE `shedule_id`='$shedule_id'";
    $shedule_sql = $mysqli->query($sql);

    $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

    $shedule_date = date('d.m.Y', strtotime($shedule_array[0]['shedule_date']));

    $sql = "SELECT `team_id`,
                   `team_name`
            FROM `team`
            WHERE `team_id` NOT IN
            (
                SELECT `game_home_team_id`
                FROM `game`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_id`='$shedule_id'
            )
            AND `team_id` NOT IN
            (
                SELECT `game_guest_team_id`
                FROM `game`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_id`='$shedule_id'
            )
            AND `team_id`!='$authorization_team_id'
            AND `team_id`!='0'
            ORDER BY `team_name` ASC";
    $team_sql = $mysqli->query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `asktoplay_home`,
                   `asktoplay_id`,
                   `team_id`,
                   `team_name`
            FROM `asktoplay`
            LEFT JOIN `team`
            ON `team_id`=`asktoplay_inviter_team_id`
            WHERE `asktoplay_shedule_id`='$shedule_id'
            AND `asktoplay_invitee_team_id`='$authorization_team_id'";
    $invitee_sql = $mysqli->query($sql);

    $invitee_array = $invitee_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `asktoplay_home`,
                   `asktoplay_id`,
                   `team_id`,
                   `team_name`
            FROM `asktoplay`
            LEFT JOIN `team`
            ON `team_id`=`asktoplay_invitee_team_id`
            WHERE `asktoplay_shedule_id`='$shedule_id'
            AND `asktoplay_inviter_team_id`='$authorization_team_id'";
    $inviter_sql = $mysqli->query($sql);

    $inviter_array = $inviter_sql->fetch_all(MYSQLI_ASSOC);

    $json_data['shedule_date']  = $shedule_date;
    $json_data['team_array']    = $team_array;
    $json_data['invitee_array'] = $invitee_array;
    $json_data['inviter_array'] = $inviter_array;
}
elseif (isset($_GET['change_role_id']))
{
    $role_id     = (int) $_GET['change_role_id'];
    $position_id = (int) $_GET['position_id'];

    $sql = "UPDATE `lineupcurrent`
            SET `lineupcurrent_role_id_" . $position_id . "`='$role_id'
            WHERE `lineupcurrent_team_id`='$authorization_team_id'
            LIMIT 1";
    $mysqli->query($sql);

    $sql = "SELECT `role_description`
            FROM `role`
            WHERE `role_id`='$role_id'
            LIMIT 1";
    $role_sql = $mysqli->query($sql);

    $role_array = $role_sql->fetch_all(MYSQLI_ASSOC);

    $json_data['role_array'] = $role_array;
}
elseif (isset($_GET['change_role_id_national']))
{
    $role_id     = (int) $_GET['change_role_id_national'];
    $position_id = (int) $_GET['position_id'];

    $sql = "UPDATE `lineupcurrent`
            SET `lineupcurrent_role_id_" . $position_id . "`='$role_id'
            WHERE `lineupcurrent_country_id`='$authorization_country_id'
            LIMIT 1";
    $mysqli->query($sql);

    $sql = "SELECT `role_description`
            FROM `role`
            WHERE `role_id`='$role_id'
            LIMIT 1";
    $role_sql = $mysqli->query($sql);

    $role_array = $role_sql->fetch_all(MYSQLI_ASSOC);

    $json_data['role_array'] = $role_array;
}
elseif (isset($_GET['to_national_player_id']))
{
    $player_id = (int) $_GET['to_national_player_id'];

    $sql = "SELECT `player_national_id`
            FROM `player`
            WHERE `player_id`='$player_id'
            LIMIT 1";
    $player_sql = $mysqli->query($sql);

    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

    $national_id = $player_array[0]['player_national_id'];

    if (0 == $national_id)
    {
        $sql = "UPDATE `player`
                SET `player_national_id`='$authorization_country_id'
                WHERE `player_id`='$player_id'
                LIMIT 1";
        $mysqli->query($sql);
    }
    else
    {
        $sql = "UPDATE `player`
                SET `player_national_id`='0'
                WHERE `player_id`='$player_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $json_data['success'] = 1;
}

print json_encode($json_data);