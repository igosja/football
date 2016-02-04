<?php

include ('include/include.php');

$json_data = array();

if (isset($_GET['player_tactic_position_id']))
{
    $position_id = (int) $_GET['player_tactic_position_id'];
    $game_id     = (int) $_GET['game_id'];

    $sql = "SELECT `count_game`,
                   `lineup_id`,
                   `mark`,
                   `name_name`,
                   `player_id`,
                   `position_description`,
                   `position_name`,
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
                SELECT `lineup_id`,
                       `lineup_player_id`,
                       `lineup_role_id`
                FROM `lineup`
                WHERE `lineup_team_id`='$authorization_team_id'
                AND `lineup_game_id`='$game_id'
                AND `lineup_position_id`='$position_id'
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

    $json_data['lineup_id']             = $lineup_array[0]['lineup_id'];
    $json_data['position_name']         = $lineup_array[0]['position_name'];
    $json_data['position_description']  = $lineup_array[0]['position_description'];
    $json_data['player_name']           = $lineup_array[0]['name_name'] . ' ' . $lineup_array[0]['surname_name'];
    $json_data['role_id']               = $lineup_array[0]['role_id'];
    $json_data['role_description']      = $lineup_array[0]['role_description'];
    $json_data['game']                  = $lineup_array[0]['count_game'];
    $json_data['mark']                  = $lineup_array[0]['mark'];
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

    $json_data['position_name'] = $position_array[0]['position_name'];
    $json_data['position_description'] = $lineup_array[0]['position_description'];
    $json_data['player_name'] = $lineup_array[0]['name_name'] . ' ' . $lineup_array[0]['surname_name'];
    $json_data['role_id'] = $lineup_array[0]['role_id'];
    $json_data['role_description'] = $lineup_array[0]['role_description'];
    $json_data['game'] = $lineup_array[0]['count_game'];
    $json_data['mark'] = $lineup_array[0]['mark'];
    $json_data['position'] = $lineup_array[0]['lineup_position'];
    $json_data['role_array'] = $role_array;
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

    for ($i = 0; $i < $count_result; $i++)
    {
        $select_array[$i]['value']  = $result_array[$i][$need . '_id'];
        $select_array[$i]['text']   = $result_array[$i][$need . '_name'];
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

    if (0 == $count_result)
    {
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
                    WHERE `shedule_id`<='$shedule_id'
                    AND `game_tournament_id`='$tournament_id'
                    AND `shedule_season_id`='$igosja_season_id'
                    ORDER BY `shedule_date` DESC
                    LIMIT 1
                )
                ORDER BY `game_id` ASC";
        $result_sql = $mysqli->query($sql);

        $count_result = $result_sql->num_rows;
    }

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

    if (0 == $count_result)
    {
        

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
                WHERE `shedule_id`>='$shedule_id'
                AND `game_tournament_id`='$tournament_id'
                AND `shedule_season_id`='$igosja_season_id'
                ORDER BY `shedule_date` ASC
                LIMIT 1
            )
            ORDER BY `game_id` ASC";
    $result_sql = $mysqli->query($sql);

    $count_result = $result_sql->num_rows;
    }

    $result_array = $result_sql->fetch_all(MYSQLI_ASSOC);

    $game_array = array();

    for ($i = 0; $i < $count_result; $i++) {
        $game_array[$i]['game_id'] = $result_array[$i]['game_id'];
        $game_array[$i]['game_guest_score'] = $result_array[$i]['game_guest_score'];
        $game_array[$i]['game_guest_team_id'] = $result_array[$i]['game_guest_team_id'];
        $game_array[$i]['game_home_score'] = $result_array[$i]['game_home_score'];
        $game_array[$i]['game_home_team_id'] = $result_array[$i]['game_home_team_id'];
        $game_array[$i]['game_played'] = $result_array[$i]['game_played'];
        $game_array[$i]['guest_team_name'] = $result_array[$i]['guest_team_name'];
        $game_array[$i]['home_team_name'] = $result_array[$i]['home_team_name'];
        $game_array[$i]['shedule_day'] = $result_array[$i]['shedule_day'];
        $game_array[$i]['shedule_date'] = date('d.m.Y', strtotime($result_array[$i]['shedule_date']));
        $game_array[$i]['shedule_id'] = $result_array[$i]['shedule_id'];
    }

    $json_data['game_array'] = $game_array;
} elseif (isset($_GET['number_national'])) {
    $number = (int) $_GET['number_national'];
    $player_id = (int) $_GET['player_id'];

    $sql = "UPDATE `player`
            SET `player_number_national`='$number'
            WHERE `player_id`='$player_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['success'] = 1;
}
elseif (isset($_GET['inbox_id']))
{
    $inbox_id = (int) $_GET['inbox_id'];

    $sql = "SELECT `inbox_asktoplay_id`,
                   `inbox_inboxtheme_id`,
                   `inbox_sender_id`,
                   `inbox_text`,
                   `inbox_title`
            FROM `inbox`
            WHERE `inbox_id`='$inbox_id'
            LIMIT 1";
    $inbox_sql = $mysqli->query($sql);

    $inbox_array = $inbox_sql->fetch_all(MYSQLI_ASSOC);

    $inboxtheme_id  = $inbox_array[0]['inbox_inboxtheme_id'];
    $asktoplay_id   = $inbox_array[0]['inbox_asktoplay_id'];
    $user_id        = $inbox_array[0]['inbox_sender_id'];

    if (in_array($inboxtheme_id, array(INBOXTHEME_ASKTOPLAY, INBOXTHEME_ASKTOPLAY_YES, INBOXTHEME_ASKTOPLAY_NO)))
    {
        $inbox_array[0]['inbox_button'] = '<button><a href="team_lineup_date_asktoplay.php?num=' . $authorization_team_id . '">Подробнее</a></button>';
    }
    elseif (INBOXTHEME_TRANSFER == $inboxtheme_id)
    {
        $inbox_array[0]['inbox_button'] = '<button><a href="team_team_transfer_center.php">Подробнее</a></button>';
    }
    elseif (INBOXTHEME_PERSONAL == $inboxtheme_id)
    {
        $inbox_array[0]['inbox_button'] = '<button><a href="profile_news_outbox.php?num=' . $authorization_user_id . '&answer=' . $user_id . '">Ответить</a></button>';
    }
    else
    {
        $inbox_array[0]['inbox_button'] = '';
    }

    $inbox_array[0]['inbox_text']   = nl2br($inbox_array[0]['inbox_text']);

    $sql = "UPDATE `inbox`
            SET `inbox_read`='1'
            WHERE `inbox_id`='$inbox_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['inbox_array'] = $inbox_array;
}
elseif (isset($_GET['outbox_id']))
{
    $inbox_id = (int) $_GET['outbox_id'];

    $sql = "SELECT `inbox_asktoplay_id`,
                   `inbox_inboxtheme_id`,
                   `inbox_text`,
                   `inbox_title`
            FROM `inbox`
            WHERE `inbox_id`='$inbox_id'
            LIMIT 1";
    $inbox_sql = $mysqli->query($sql);

    $inbox_array = $inbox_sql->fetch_all(MYSQLI_ASSOC);

    $inbox_array[0]['inbox_button'] = '';
    $inbox_array[0]['inbox_text']   = nl2br($inbox_array[0]['inbox_text']);

    $json_data['inbox_array'] = $inbox_array;
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

    $count_note = $note_sql->num_rows;
    $note_array = $note_sql->fetch_all(MYSQLI_ASSOC);

    if (1 == $count_note)
    {
        $note_array[0]['note_text_nl2br'] = nl2br($note_array[0]['note_text']);
    }

    $json_data['note_array'] = $note_array;
}
elseif (isset($_GET['asktoplay']))
{
    $shedule_id = (int) $_GET['asktoplay'];

    if (isset($_GET['delete']))
    {
        $delete = (int) $_GET['delete'];

        $sql = "SELECT `team_user_id`
                FROM `asktoplay`
                LEFT JOIN `team`
                ON `team_id`=`asktoplay_inviter_team_id`
                WHERE `asktoplay_shedule_id`='$shedule_id'
                AND `asktoplay_id`='$delete'
                AND (`asktoplay_invitee_team_id`='$authorization_team_id'
                OR `asktoplay_inviter_team_id`='$authorization_team_id')
                LIMIT 1";
        $asktoplay_sql = $mysqli->query($sql);

        $count_asktoplay = $asktoplay_sql->num_rows;

        if (0 != $count_asktoplay)
        {
            $asktoplay_array = $asktoplay_sql->fetch_all(MYSQLI_ASSOC);

            $user_id = $asktoplay_array[0]['team_user_id'];

            $sql = "SELECT `inboxtheme_name`,
                           `inboxtheme_text`
                    FROM `inboxtheme`
                    WHERE `inboxtheme_id`='" . INBOXTHEME_ASKTOPLAY_NO . "'
                    LIMIT 1";
            $inboxtheme_sql = $mysqli->query($sql);

            $inboxtheme_array = $inboxtheme_sql->fetch_all(MYSQLI_ASSOC);

            $inboxtheme_name = $inboxtheme_array[0]['inboxtheme_name'];
            $inboxtheme_text = $inboxtheme_array[0]['inboxtheme_text'];
            $inboxtheme_text = sprintf($inboxtheme_text, $authorization_team_name);

            $sql = "INSERT INTO `inbox`
                    SET `inbox_asktoplay_id`='$delete',
                        `inbox_date`=CURDATE(),
                        `inbox_inboxtheme_id`='" . INBOXTHEME_ASKTOPLAY_NO . "',
                        `inbox_title`='$inboxtheme_name',
                        `inbox_text`='$inboxtheme_text',
                        `inbox_user_id`='$user_id'";
            $mysqli->query($sql);

            $sql = "DELETE FROM `asktoplay`
                    WHERE `asktoplay_id`='$delete'
                    LIMIT 1";
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

            $asktoplay_id = $mysqli->insert_id;

            $sql = "SELECT `team_name`,
                           `team_user_id`
                    FROM `team`
                    WHERE `team_id`='$invite'
                    LIMIT 1";
            $team_sql = $mysqli->query($sql);

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

            $team_name  = $team_array[0]['team_name'];
            $user_id    = $team_array[0]['team_user_id'];

            if (1 == $home)
            {
                $sql = "SELECT `city_name`,
                               `stadium_name`
                        FROM `team`
                        LEFT JOIN `stadium`
                        ON `stadium_team_id`=`team_id`
                        LEFT JOIN `city`
                        ON `city_id`=`team_city_id`
                        WHERE `team_id`='$authorization_team_id'
                        LIMIT 1";
            }
            else
            {
                $sql = "SELECT `city_name`,
                               `stadium_name`
                        FROM `team`
                        LEFT JOIN `stadium`
                        ON `stadium_team_id`=`team_id`
                        LEFT JOIN `city`
                        ON `city_id`=`team_city_id`
                        WHERE `team_id`='$invite'
                        LIMIT 1";
            }

            $stadium_sql = $mysqli->query($sql);

            $stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

            $city_name      = $stadium_array[0]['city_name'];
            $stadium_name   = $stadium_array[0]['stadium_name'];

            $sql = "SELECT `shedule_date`
                    FROM `shedule`
                    WHERE `shedule_id`='$shedule_id'
                    LIMIT 1";
            $shedule_sql = $mysqli->query($sql);

            $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

            $shedule_date = $shedule_array[0]['shedule_date'];
            $shedule_date = date('d.m.Y', strtotime($shedule_date));

            $sql = "SELECT `inboxtheme_name`,
                           `inboxtheme_text`
                    FROM `inboxtheme`
                    WHERE `inboxtheme_id`='" . INBOXTHEME_ASKTOPLAY . "'
                    LIMIT 1";
            $inboxtheme_sql = $mysqli->query($sql);

            $inboxtheme_array = $inboxtheme_sql->fetch_all(MYSQLI_ASSOC);

            $inboxtheme_name = $inboxtheme_array[0]['inboxtheme_name'];
            $inboxtheme_text = $inboxtheme_array[0]['inboxtheme_text'];
            $inboxtheme_text = sprintf($inboxtheme_text, $authorization_team_name, $stadium_name, $city_name, $shedule_date);

            $sql = "INSERT INTO `inbox`
                    SET `inbox_asktoplay_id`='$asktoplay_id',
                        `inbox_date`=CURDATE(),
                        `inbox_inboxtheme_id`='" . INBOXTHEME_ASKTOPLAY . "',
                        `inbox_title`='$inboxtheme_name',
                        `inbox_text`='$inboxtheme_text',
                        `inbox_user_id`='$user_id'";
            $mysqli->query($sql);
        }
    }

    $sql = "SELECT `shedule_date`,
                   `shedule_tournamenttype_id`
            FROM `shedule`
            WHERE `shedule_id`='$shedule_id'";
    $shedule_sql = $mysqli->query($sql);

    $shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

    $shedule_date       = date('d.m.Y', strtotime($shedule_array[0]['shedule_date']));
    $tournamenttype_id  = $shedule_array[0]['shedule_tournamenttype_id'];

    if (TOURNAMENT_TYPE_CUP == $tournamenttype_id)
    {
        $addition_sql_1 = "LEFT JOIN `cupparticipant`
                           ON `cupparticipant_team_id`=`team_id`";
        $addition_sql_2 = "AND `cupparticipant_season_id`='$igosja_season_id'
                           AND `cupparticipant_out`!='0'";
    }
    else
    {
        $addition_sql_1 = $addition_sql_2 = '';
    }

    $sql = "SELECT `team_id`,
                   `team_name`
            FROM `team`
            $addition_sql_1
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
            AND `team_user_id`!='0'
            $addition_sql_2
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
    $json_data['num']           = $authorization_team_id;
    $json_data['team_array']    = $team_array;
    $json_data['invitee_array'] = $invitee_array;
    $json_data['inviter_array'] = $inviter_array;
}
elseif (isset($_GET['change_role_id']))
{
    $role_id = (int) $_GET['change_role_id'];

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
    $role_id = (int) $_GET['change_role_id_national'];
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

    if (0 == $national_id) {
        $sql = "UPDATE `player`
                SET `player_national_id`='$authorization_country_id'
                WHERE `player_id`='$player_id'
                LIMIT 1";
        $mysqli->query($sql);
    } else {
        $sql = "UPDATE `player`
                SET `player_national_id`='0'
                WHERE `player_id`='$player_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $json_data['success'] = 1;
}

print json_encode($json_data);