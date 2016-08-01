<?php

include (__DIR__ . '/include/include.php');

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

    $count_lineup = $lineup_sql->num_rows;
    $lineup_array = $lineup_sql->fetch_all(1);

    $sql = "SELECT `role_id`,
                   `role_name`
            FROM `positionrole`
            LEFT JOIN `role`
            ON `role_id`=`positionrole_role_id`
            WHERE `positionrole_position_id`='$position_id'
            ORDER BY `positionrole_id` ASC";
    $role_sql = $mysqli->query($sql);

    $role_array = $role_sql->fetch_all(1);

    if (0 != $count_lineup)
    {
        $json_data['lineup_id']             = $lineup_array[0]['lineup_id'];
        $json_data['position_name']         = $lineup_array[0]['position_name'];
        $json_data['position_description']  = $lineup_array[0]['position_description'];
        $json_data['player_name']           = $lineup_array[0]['name_name'] . ' ' . $lineup_array[0]['surname_name'];
        $json_data['role_id']               = $lineup_array[0]['role_id'];
        $json_data['role_description']      = $lineup_array[0]['role_description'];
        $json_data['game']                  = $lineup_array[0]['count_game'];
        $json_data['mark']                  = $lineup_array[0]['mark'];
    }
    else
    {
        $json_data['lineup_id']             = 0;
        $json_data['position_name']         = '-';
        $json_data['position_description']  = '-';
        $json_data['player_name']           = '-';
        $json_data['role_id']               = 0;
        $json_data['role_description']      = '-';
        $json_data['game']                  = 0;
        $json_data['mark']                  = 0;
    }

    $json_data['role_array'] = $role_array;
}
elseif (isset($_GET['national_player_tactic_position_id']))
{
    $position_id = (int) $_GET['national_player_tactic_position_id'];
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
                WHERE `lineup_country_id`='$authorization_country_id'
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

    $lineup_array = $lineup_sql->fetch_all(1);

    $sql = "SELECT `role_id`,
                   `role_name`
            FROM `positionrole`
            LEFT JOIN `role`
            ON `role_id`=`positionrole_role_id`
            WHERE `positionrole_position_id`='$position_id'
            ORDER BY `positionrole_id` ASC";
    $role_sql = $mysqli->query($sql);

    $role_array = $role_sql->fetch_all(1);

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

    $position_array = $position_sql->fetch_all(1);

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

    $lineup_array = $lineup_sql->fetch_all(1);

    $sql = "SELECT `role_id`,
                   `role_name`
            FROM `positionrole`
            LEFT JOIN `role`
            ON `role_id`=`positionrole_role_id`
            WHERE `positionrole_position_id`='$position_id'
            ORDER BY `positionrole_id` ASC";
    $role_sql = $mysqli->query($sql);

    $role_array = $role_sql->fetch_all(1);

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
    $result_array = $result_sql->fetch_all(1);

    $select_array = array();

    for ($i=0; $i<$count_result; $i++)
    {
        $select_array[$i]['value']  = $result_array[$i][$need . '_id'];
        $select_array[$i]['text']   = $result_array[$i][$need . '_name'];
    }

    $json_data['select_array'] = $select_array;
}
elseif (isset($_GET['stage_prev']))
{
    $stage_id       = (int) $_GET['stage_prev'];
    $tournament_id  = (int) $_GET['tournament'];

    if (TOURNAMENT_CHAMPIONS_LEAGUE != $tournament_id ||
        (TOURNAMENT_CHAMPIONS_LEAGUE == $tournament_id &&
        in_array($stage_id, array(1, 2, 3, 4, 5, 6, 39, 40, 41, 42, 47, 48, 49))))
    {
        if (TOURNAMENT_CHAMPIONS_LEAGUE == $tournament_id &&
            in_array($stage_id, array(1, 2, 3, 4, 5, 6)))
        {
            $sql = "SELECT `stage_id`,
                           `stage_name`
                    FROM `stage`
                    WHERE `stage_id`='42'
                    LIMIT 1";
            $stage_sql = $mysqli->query($sql);
        }
        else
        {
            $sql = "SELECT `stage_id`,
                           `stage_name`
                    FROM `game`
                    LEFT JOIN `shedule`
                    ON `shedule_id`=`game_shedule_id`
                    LEFT JOIN `stage`
                    ON `game_stage_id`=`stage_id`
                    WHERE `game_tournament_id`='$tournament_id'
                    AND `game_stage_id`<'$stage_id'
                    AND `game_stage_id`>'6'
                    AND `shedule_season_id`='$igosja_season_id'
                    ORDER BY `game_stage_id` DESC
                    LIMIT 1";
            $stage_sql = $mysqli->query($sql);

            $count_stage = $stage_sql->num_rows;

            if (0 == $count_stage)
            {
                $sql = "SELECT `stage_id`,
                               `stage_name`
                        FROM `game`
                        LEFT JOIN `shedule`
                        ON `shedule_id`=`game_shedule_id`
                        LEFT JOIN `stage`
                        ON `game_stage_id`=`stage_id`
                        WHERE `game_tournament_id`='$tournament_id'
                        AND `game_stage_id`>='$stage_id'
                        AND `game_stage_id`>'6'
                        AND `shedule_season_id`='$igosja_season_id'
                        ORDER BY `game_stage_id` ASC
                        LIMIT 1";
                $stage_sql = $mysqli->query($sql);
            }
        }

        $stage_array = $stage_sql->fetch_all(1);

        $stage_id   = $stage_array[0]['stage_id'];
        $stage_name = $stage_array[0]['stage_name'];

        $sql = "SELECT `game_first_game_id`,
                       `game_guest_score`,
                       `game_guest_team_id`,
                       `game_home_score`,
                       `game_home_team_id`,
                       `game_id`,
                       `game_played`,
                       `guest_team`.`team_name` AS `guest_team_name`,
                       `home_team`.`team_name` AS `home_team_name`
                FROM `game`
                LEFT JOIN `team` AS `guest_team`
                ON `guest_team`.`team_id`=`game_guest_team_id`
                LEFT JOIN `team` AS `home_team`
                ON `home_team`.`team_id`=`game_home_team_id`
                LEFT JOIN `shedule`
                ON `game_shedule_id`=`shedule_id`
                WHERE `game_stage_id`='$stage_id'
                AND `game_tournament_id`='$tournament_id'
                AND `shedule_season_id`='$igosja_season_id'
                ORDER BY `game_first_game_id` ASC, `game_id` ASC";
        $stage_game_sql = $mysqli->query($sql);

        $count_stage_game = $stage_game_sql->num_rows;
        $stage_game_array = $stage_game_sql->fetch_all(1);

        $stage_array = array();

        for ($i=0; $i<$count_stage_game; $i++)
        {
            $first_game_id  = $stage_game_array[$i]['game_first_game_id'];
            $game_played    = $stage_game_array[$i]['game_played'];
            $game_id        = $stage_game_array[$i]['game_id'];

            if (0 == $first_game_id)
            {
                $home_team_id       = $stage_game_array[$i]['game_home_team_id'];
                $home_team_name     = $stage_game_array[$i]['home_team_name'];
                $home_score_1       = $stage_game_array[$i]['game_home_score'];
                $guest_team_id      = $stage_game_array[$i]['game_guest_team_id'];
                $guest_team_name    = $stage_game_array[$i]['guest_team_name'];
                $guest_score_1      = $stage_game_array[$i]['game_guest_score'];

                $stage_array[$game_id] = array
                (
                    'home_team_id'      => $home_team_id,
                    'home_team_name'    => $home_team_name,
                    'home_score_1'      => $home_score_1,
                    'guest_team_id'     => $guest_team_id,
                    'guest_team_name'   => $guest_team_name,
                    'guest_score_1'     => $guest_score_1,
                    'game_played_1'     => $game_played,
                    'game_id_1'         => $game_id,
                    'stage_id'          => $stage_id,
                    'stage_name'        => $stage_name,
                );
            }
            else
            {
                $home_score_2   = $stage_game_array[$i]['game_guest_score'];
                $guest_score_2  = $stage_game_array[$i]['game_home_score'];

                $stage_array[$first_game_id]['home_score_2']    = $home_score_2;
                $stage_array[$first_game_id]['guest_score_2']   = $guest_score_2;
                $stage_array[$first_game_id]['game_played_2']   = $game_played;
                $stage_array[$first_game_id]['game_id_2']       = $game_id;
            }
        }
    }
    else
    {
        $sql = "SELECT `league_draw`,
                       `league_game`,
                       `league_group`,
                       `league_loose`,
                       `league_place`,
                       `league_point`,
                       `league_win`,
                       `team_id`,
                       `team_name`
                FROM `league`
                LEFT JOIN `team`
                ON `league_team_id`=`team_id`
                WHERE `league_season_id`='$igosja_season_id'
                ORDER BY `league_group` ASC, `league_place` ASC";
        $stage_sql = $mysqli->query($sql);

        $stage_array = $stage_sql->fetch_all(1);
    }

    $stage_array = array_values($stage_array);

    $json_data['stage_array'] = $stage_array;
}
elseif (isset($_GET['stage_next']))
{
    $stage_id       = (int) $_GET['stage_next'];
    $tournament_id  = (int) $_GET['tournament'];

    if (TOURNAMENT_CHAMPIONS_LEAGUE != $tournament_id ||
        (TOURNAMENT_CHAMPIONS_LEAGUE == $tournament_id &&
        in_array($stage_id, array(1, 2, 3, 4, 5, 6, 39, 40, 41, 46, 47, 48, 49))))
    {
        if (TOURNAMENT_CHAMPIONS_LEAGUE == $tournament_id &&
            in_array($stage_id, array(1, 2, 3, 4, 5, 6)))
        {
            $sql = "SELECT `stage_id`,
                           `stage_name`
                    FROM `stage`
                    WHERE `stage_id`='46'
                    LIMIT 1";
            $stage_sql = $mysqli->query($sql);
        }
        else
        {
            $sql = "SELECT `stage_id`,
                           `stage_name`
                    FROM `game`
                    LEFT JOIN `shedule`
                    ON `shedule_id`=`game_shedule_id`
                    LEFT JOIN `stage`
                    ON `game_stage_id`=`stage_id`
                    WHERE `game_tournament_id`='$tournament_id'
                    AND `game_stage_id`>'$stage_id'
                    AND `game_stage_id`>'6'
                    AND `shedule_season_id`='$igosja_season_id'
                    ORDER BY `game_stage_id` ASC
                    LIMIT 1";
            $stage_sql = $mysqli->query($sql);

            $count_stage = $stage_sql->num_rows;

            if (0 == $count_stage)
            {
                $sql = "SELECT `stage_id`,
                               `stage_name`
                        FROM `game`
                        LEFT JOIN `shedule`
                        ON `shedule_id`=`game_shedule_id`
                        LEFT JOIN `stage`
                        ON `game_stage_id`=`stage_id`
                        WHERE `game_tournament_id`='$tournament_id'
                        AND `game_stage_id`<='$stage_id'
                        AND `game_stage_id`>'6'
                        AND `shedule_season_id`='$igosja_season_id'
                        ORDER BY `game_stage_id` DESC
                        LIMIT 1";
                $stage_sql = $mysqli->query($sql);
            }
        }

        $stage_array = $stage_sql->fetch_all(1);

        $stage_id   = $stage_array[0]['stage_id'];
        $stage_name = $stage_array[0]['stage_name'];

        $sql = "SELECT `game_first_game_id`,
                       `game_guest_score`,
                       `game_guest_team_id`,
                       `game_home_score`,
                       `game_home_team_id`,
                       `game_id`,
                       `game_played`,
                       `guest_team`.`team_name` AS `guest_team_name`,
                       `home_team`.`team_name` AS `home_team_name`
                FROM `game`
                LEFT JOIN `team` AS `guest_team`
                ON `guest_team`.`team_id`=`game_guest_team_id`
                LEFT JOIN `team` AS `home_team`
                ON `home_team`.`team_id`=`game_home_team_id`
                LEFT JOIN `shedule`
                ON `game_shedule_id`=`shedule_id`
                WHERE `game_stage_id`='$stage_id'
                AND `game_tournament_id`='$tournament_id'
                AND `shedule_season_id`='$igosja_season_id'
                ORDER BY `game_first_game_id` ASC, `game_id` ASC";
        $stage_game_sql = $mysqli->query($sql);

        $count_stage_game = $stage_game_sql->num_rows;
        $stage_game_array = $stage_game_sql->fetch_all(1);

        $stage_array = array();

        for ($i=0; $i<$count_stage_game; $i++)
        {
            $first_game_id  = $stage_game_array[$i]['game_first_game_id'];
            $game_played    = $stage_game_array[$i]['game_played'];
            $game_id        = $stage_game_array[$i]['game_id'];

            if (0 == $first_game_id)
            {
                $home_team_id       = $stage_game_array[$i]['game_home_team_id'];
                $home_team_name     = $stage_game_array[$i]['home_team_name'];
                $home_score_1       = $stage_game_array[$i]['game_home_score'];
                $guest_team_id      = $stage_game_array[$i]['game_guest_team_id'];
                $guest_team_name    = $stage_game_array[$i]['guest_team_name'];
                $guest_score_1      = $stage_game_array[$i]['game_guest_score'];

                $stage_array[$game_id] = array
                (
                    'home_team_id'      => $home_team_id,
                    'home_team_name'    => $home_team_name,
                    'home_score_1'      => $home_score_1,
                    'guest_team_id'     => $guest_team_id,
                    'guest_team_name'   => $guest_team_name,
                    'guest_score_1'     => $guest_score_1,
                    'game_played_1'     => $game_played,
                    'game_id_1'         => $game_id,
                    'stage_id'          => $stage_id,
                    'stage_name'        => $stage_name,
                );
            }
            else
            {
                $home_score_2   = $stage_game_array[$i]['game_guest_score'];
                $guest_score_2  = $stage_game_array[$i]['game_home_score'];

                $stage_array[$first_game_id]['home_score_2']    = $home_score_2;
                $stage_array[$first_game_id]['guest_score_2']   = $guest_score_2;
                $stage_array[$first_game_id]['game_played_2']   = $game_played;
                $stage_array[$first_game_id]['game_id_2']       = $game_id;
            }
        }
    }
    else
    {
        $sql = "SELECT `league_draw`,
                       `league_game`,
                       `league_group`,
                       `league_loose`,
                       `league_place`,
                       `league_point`,
                       `league_win`,
                       `team_id`,
                       `team_name`
                FROM `league`
                LEFT JOIN `team`
                ON `league_team_id`=`team_id`
                WHERE `league_season_id`='$igosja_season_id'
                ORDER BY `league_group` ASC, `league_place` ASC";
        $stage_sql = $mysqli->query($sql);

        $stage_array = $stage_sql->fetch_all(1);
    }

    $stage_array = array_values($stage_array);

    $json_data['stage_array'] = $stage_array;
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

    $result_array = $result_sql->fetch_all(1);

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

    $result_array = $result_sql->fetch_all(1);

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
elseif (isset($_GET['shedule_worldcup_prev']))
{
    $shedule_id     = (int) $_GET['shedule_worldcup_prev'];
    $tournament_id  = (int) $_GET['tournament'];

    $sql = "SELECT `game_id`,
                   `game_guest_score`,
                   `game_guest_country_id`,
                   `game_home_score`,
                   `game_home_country_id`,
                   `game_played`,
                   `guest_country`.`country_name` AS `guest_country_name`,
                   `home_country`.`country_name` AS `home_country_name`,
                   `shedule_date`,
                   DATE_FORMAT(`shedule_date`,'%W') AS `shedule_day`,
                   `shedule_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `country` AS `home_country`
            ON `home_country`.`country_id`=`game_home_country_id`
            LEFT JOIN `country` AS `guest_country`
            ON `guest_country`.`country_id`=`game_guest_country_id`
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
                       `game_guest_country_id`,
                       `game_home_score`,
                       `game_home_country_id`,
                       `game_played`,
                       `guest_country`.`country_name` AS `guest_country_name`,
                       `home_country`.`country_name` AS `home_country_name`,
                       `shedule_date`,
                       DATE_FORMAT(`shedule_date`,'%W') AS `shedule_day`,
                       `shedule_id`
                FROM `game`
                LEFT JOIN `shedule`
                ON `game_shedule_id`=`shedule_id`
                LEFT JOIN `country` AS `home_country`
                ON `home_country`.`country_id`=`game_home_country_id`
                LEFT JOIN `country` AS `guest_country`
                ON `guest_country`.`country_id`=`game_guest_country_id`
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

    $result_array = $result_sql->fetch_all(1);

    $game_array = array();

    for ($i=0; $i<$count_result; $i++)
    {
        $game_array[$i]['game_id']                  = $result_array[$i]['game_id'];
        $game_array[$i]['game_guest_score']         = $result_array[$i]['game_guest_score'];
        $game_array[$i]['game_guest_country_id']    = $result_array[$i]['game_guest_country_id'];
        $game_array[$i]['game_home_score']          = $result_array[$i]['game_home_score'];
        $game_array[$i]['game_home_country_id']     = $result_array[$i]['game_home_country_id'];
        $game_array[$i]['game_played']              = $result_array[$i]['game_played'];
        $game_array[$i]['guest_country_name']       = $result_array[$i]['guest_country_name'];
        $game_array[$i]['home_country_name']        = $result_array[$i]['home_country_name'];
        $game_array[$i]['shedule_day']              = $result_array[$i]['shedule_day'];
        $game_array[$i]['shedule_date']             = date('d.m.Y', strtotime($result_array[$i]['shedule_date']));
        $game_array[$i]['shedule_id']               = $result_array[$i]['shedule_id'];
    }

    $json_data['game_array'] = $game_array;
}
elseif (isset($_GET['shedule_worldcup_next']))
{
    $shedule_id     = (int) $_GET['shedule_worldcup_next'];
    $tournament_id  = (int) $_GET['tournament'];

    $sql = "SELECT `game_id`,
                   `game_guest_score`,
                   `game_guest_country_id`,
                   `game_home_score`,
                   `game_home_country_id`,
                   `game_played`,
                   `guest_country`.`country_name` AS `guest_country_name`,
                   `home_country`.`country_name` AS `home_country_name`,
                   `shedule_date`,
                   DATE_FORMAT(`shedule_date`,'%W') AS `shedule_day`,
                   `shedule_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `country` AS `home_country`
            ON `home_country`.`country_id`=`game_home_country_id`
            LEFT JOIN `country` AS `guest_country`
            ON `guest_country`.`country_id`=`game_guest_country_id`
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
                       `game_guest_country_id`,
                       `game_home_score`,
                       `game_home_country_id`,
                       `game_played`,
                       `guest_country`.`country_name` AS `guest_country_name`,
                       `home_country`.`country_name` AS `home_country_name`,
                       `shedule_date`,
                       DATE_FORMAT(`shedule_date`,'%W') AS `shedule_day`,
                       `shedule_id`
                FROM `game`
                LEFT JOIN `shedule`
                ON `game_shedule_id`=`shedule_id`
                LEFT JOIN `country` AS `home_country`
                ON `home_country`.`country_id`=`game_home_country_id`
                LEFT JOIN `country` AS `guest_country`
                ON `guest_country`.`country_id`=`game_guest_country_id`
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

    $result_array = $result_sql->fetch_all(1);

    $game_array = array();

    for ($i=0; $i<$count_result; $i++)
    {
        $game_array[$i]['game_id']                  = $result_array[$i]['game_id'];
        $game_array[$i]['game_guest_score']         = $result_array[$i]['game_guest_score'];
        $game_array[$i]['game_guest_country_id']    = $result_array[$i]['game_guest_country_id'];
        $game_array[$i]['game_home_score']          = $result_array[$i]['game_home_score'];
        $game_array[$i]['game_home_country_id']     = $result_array[$i]['game_home_country_id'];
        $game_array[$i]['game_played']              = $result_array[$i]['game_played'];
        $game_array[$i]['guest_country_name']       = $result_array[$i]['guest_country_name'];
        $game_array[$i]['home_country_name']        = $result_array[$i]['home_country_name'];
        $game_array[$i]['shedule_day']              = $result_array[$i]['shedule_day'];
        $game_array[$i]['shedule_date']             = date('d.m.Y', strtotime($result_array[$i]['shedule_date']));
        $game_array[$i]['shedule_id']               = $result_array[$i]['shedule_id'];
    }

    $json_data['game_array'] = $game_array;
}
elseif (isset($_GET['number_national']))
{
    $number     = (int) $_GET['number_national'];
    $player_id  = (int) $_GET['player_id'];

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

    $inbox_array = $inbox_sql->fetch_all(1);

    $inboxtheme_id  = $inbox_array[0]['inbox_inboxtheme_id'];
    $asktoplay_id   = $inbox_array[0]['inbox_asktoplay_id'];
    $user_id        = $inbox_array[0]['inbox_sender_id'];

    if (in_array($inboxtheme_id, array(INBOXTHEME_ASKTOPLAY, INBOXTHEME_ASKTOPLAY_YES, INBOXTHEME_ASKTOPLAY_NO)))
    {
        $inbox_array[0]['inbox_button'] = '<a href="team_lineup_date_asktoplay.php?num=' . $authorization_team_id . '" class="button-link"><button>Подробнее</button></a>';
    }
    elseif (INBOXTHEME_TRANSFER == $inboxtheme_id)
    {
        $inbox_array[0]['inbox_button'] = '<a href="team_team_transfer_center.php?num=' . $authorization_team_id . '" class="button-link"><button>Подробнее</button></a>';
    }
    elseif (INBOXTHEME_PERSONAL == $inboxtheme_id)
    {
        $inbox_array[0]['inbox_button'] = '<a href="profile_news_outbox.php?num=' . $authorization_user_id . '&answer=' . $user_id . '" class="button-link"><button>Ответить</button></a>';
    }
    else
    {
        $inbox_array[0]['inbox_button'] = '';
    }

    if (INBOXTHEME_PERSONAL == $inboxtheme_id)
    {
        $sql = "SELECT `inbox_date`,
                       `inbox_inboxtheme_id`,
                       `inbox_title`,
                       `inbox_text`,
                       `user_id`,
                       `user_login`
                FROM `inbox`
                LEFT JOIN `user`
                ON `inbox_sender_id`=`user_id`
                WHERE ((`inbox_user_id`='$authorization_user_id'
                AND `inbox_sender_id`='$user_id')
                OR (`inbox_user_id`='$user_id'
                AND `inbox_sender_id`='$authorization_user_id'))
                AND `inbox_inboxtheme_id`='" . INBOXTHEME_PERSONAL . "'
                ORDER BY `inbox_id` DESC";
        $inbox_sql = $mysqli->query($sql);

        $inbox_array = $inbox_sql->fetch_all(1);

        $inbox_array[0]['inbox_button'] = '<a href="profile_news_outbox.php?num=' . $authorization_user_id . '&answer=' . $user_id . '" class="button-link"><button>Ответить</button></a>';

        $json_data['inbox_array'] = $inbox_array;
    }
    else
    {
        $inbox_array[0]['inbox_text'] = nl2br($inbox_array[0]['inbox_text']);

        $json_data['inbox_array'] = $inbox_array;
    }

    $sql = "UPDATE `inbox`
            SET `inbox_read`='1'
            WHERE `inbox_id`='$inbox_id'
            LIMIT 1";
    $mysqli->query($sql);

    $json_data['user_id'] = $authorization_user_id;
}
elseif (isset($_GET['outbox_id']))
{
    $inbox_id = (int) $_GET['outbox_id'];

    $sql = "SELECT `inbox_asktoplay_id`,
                   `inbox_inboxtheme_id`,
                   `inbox_user_id`,
                   `inbox_text`,
                   `inbox_title`
            FROM `inbox`
            WHERE `inbox_id`='$inbox_id'
            LIMIT 1";
    $inbox_sql = $mysqli->query($sql);

    $inbox_array = $inbox_sql->fetch_all(1);

    $user_id        = $inbox_array[0]['inbox_user_id'];
    $inboxtheme_id  = $inbox_array[0]['inbox_inboxtheme_id'];

    $inbox_array[0]['inbox_button'] = '';

    if (INBOXTHEME_PERSONAL == $inboxtheme_id)
    {
        $sql = "SELECT `inbox_date`,
                       `inbox_title`,
                       `inbox_text`,
                       `user_id`,
                       `user_login`
                FROM `inbox`
                LEFT JOIN `user`
                ON `inbox_sender_id`=`user_id`
                WHERE ((`inbox_user_id`='$authorization_user_id'
                AND `inbox_sender_id`='$user_id')
                OR (`inbox_user_id`='$user_id'
                AND `inbox_sender_id`='$authorization_user_id'))
                AND `inbox_inboxtheme_id`='" . INBOXTHEME_PERSONAL . "'
                ORDER BY `inbox_id` DESC";
        $inbox_sql = $mysqli->query($sql);

        $inbox_array = $inbox_sql->fetch_all(1);

        $json_data['inbox_array'] = $inbox_array;
    }
    else
    {
        $inbox_array[0]['inbox_text'] = nl2br($inbox_array[0]['inbox_text']);

        $json_data['inbox_array'] = $inbox_array;
    }

    $json_data['user_id'] = $authorization_user_id;
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
    $note_array = $note_sql->fetch_all(1);

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
            $asktoplay_array = $asktoplay_sql->fetch_all(1);

            $user_id = $asktoplay_array[0]['team_user_id'];

            $sql = "SELECT `inboxtheme_name`,
                           `inboxtheme_text`
                    FROM `inboxtheme`
                    WHERE `inboxtheme_id`='" . INBOXTHEME_ASKTOPLAY_NO . "'
                    LIMIT 1";
            $inboxtheme_sql = $mysqli->query($sql);

            $inboxtheme_array = $inboxtheme_sql->fetch_all(1);

            $inboxtheme_name = $inboxtheme_array[0]['inboxtheme_name'];
            $inboxtheme_text = $inboxtheme_array[0]['inboxtheme_text'];
            $inboxtheme_text = sprintf($inboxtheme_text, $authorization_team_name);

            $sql = "INSERT INTO `inbox`
                    SET `inbox_asktoplay_id`='$delete',
                        `inbox_date`=UNIX_TIMESTAMP(),
                        `inbox_inboxtheme_id`='" . INBOXTHEME_ASKTOPLAY_NO . "',
                        `inbox_title`='$inboxtheme_name',
                        `inbox_text`='$inboxtheme_text',
                        `inbox_sender_id`='$authorization_user_id',
                        `inbox_user_id`='$user_id'";
            $mysqli->query($sql);

            $sql = "UPDATE `asktoplay`
                    SET `asktoplay_delete`='1'
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

        $check_array = $check_sql->fetch_all(1);
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

            $team_array = $team_sql->fetch_all(1);

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

            $stadium_array = $stadium_sql->fetch_all(1);

            $city_name      = $stadium_array[0]['city_name'];
            $stadium_name   = $stadium_array[0]['stadium_name'];

            $sql = "SELECT `shedule_date`
                    FROM `shedule`
                    WHERE `shedule_id`='$shedule_id'
                    LIMIT 1";
            $shedule_sql = $mysqli->query($sql);

            $shedule_array = $shedule_sql->fetch_all(1);

            $shedule_date = $shedule_array[0]['shedule_date'];
            $shedule_date = date('d.m.Y', strtotime($shedule_date));

            $sql = "SELECT `inboxtheme_name`,
                           `inboxtheme_text`
                    FROM `inboxtheme`
                    WHERE `inboxtheme_id`='" . INBOXTHEME_ASKTOPLAY . "'
                    LIMIT 1";
            $inboxtheme_sql = $mysqli->query($sql);

            $inboxtheme_array = $inboxtheme_sql->fetch_all(1);

            $inboxtheme_name = $inboxtheme_array[0]['inboxtheme_name'];
            $inboxtheme_text = $inboxtheme_array[0]['inboxtheme_text'];
            $inboxtheme_text = sprintf($inboxtheme_text, $authorization_team_name, $stadium_name, $city_name, $shedule_date);

            $sql = "INSERT INTO `inbox`
                    SET `inbox_asktoplay_id`='$asktoplay_id',
                        `inbox_date`=UNIX_TIMESTAMP(),
                        `inbox_inboxtheme_id`='" . INBOXTHEME_ASKTOPLAY . "',
                        `inbox_sender_id`='$authorization_user_id',
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

    $shedule_array = $shedule_sql->fetch_all(1);

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

    $team_array = $team_sql->fetch_all(1);

    $sql = "SELECT `asktoplay_home`,
                   `asktoplay_id`,
                   `team_id`,
                   `team_name`
            FROM `asktoplay`
            LEFT JOIN `team`
            ON `team_id`=`asktoplay_inviter_team_id`
            WHERE `asktoplay_shedule_id`='$shedule_id'
            AND `asktoplay_invitee_team_id`='$authorization_team_id'
            AND `asktoplay_delete`='0'";
    $invitee_sql = $mysqli->query($sql);

    $invitee_array = $invitee_sql->fetch_all(1);

    $sql = "SELECT `asktoplay_home`,
                   `asktoplay_id`,
                   `team_id`,
                   `team_name`
            FROM `asktoplay`
            LEFT JOIN `team`
            ON `team_id`=`asktoplay_invitee_team_id`
            WHERE `asktoplay_shedule_id`='$shedule_id'
            AND `asktoplay_inviter_team_id`='$authorization_team_id'
            AND `asktoplay_delete`='0'";
    $inviter_sql = $mysqli->query($sql);

    $inviter_array = $inviter_sql->fetch_all(1);

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

    $role_array = $role_sql->fetch_all(1);

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

    $player_array = $player_sql->fetch_all(1);

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
elseif (isset($_GET['application_country_id']))
{
    $country_id = (int) $_GET['application_country_id'];

    $sql = "SELECT `coachapplication_text`
            FROM `coachapplication`
            WHERE `coachapplication_season_id`='$igosja_season_id'
            AND `coachapplication_user_id`='$authorization_user_id'
            AND `coachapplication_country_id`='$country_id'
            LIMIT 1";
    $application_sql = $mysqli->query($sql);

    $count_application = $application_sql->num_rows;
    $application_array = $application_sql->fetch_all(1);

    if (0 == $count_application)
    {
        $json_data['coachapplication_text'] = '';
    }
    else
    {
        $json_data['coachapplication_text'] = $application_array[0]['coachapplication_text'];
    }
}
elseif (isset($_GET['registration_login']))
{
    $registration_login = $_GET['registration_login'];

    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_login`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $registration_login);
    $prepare->execute();

    $user_sql = $prepare->get_result();

    $prepare->close();

    $user_array = $user_sql->fetch_all(1);
    $count_user = $user_array[0]['count'];

    $json_data['count_user'] = $count_user;
}
elseif (isset($_GET['registration_email']))
{
    $registration_email = $_GET['registration_email'];

    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_email`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $registration_email);
    $prepare->execute();

    $user_sql = $prepare->get_result();

    $prepare->close();

    $user_array = $user_sql->fetch_all(1);
    $count_user = $user_array[0]['count'];

    $json_data['count_user'] = $count_user;
}
elseif (isset($_GET['questionary_login']))
{
    $questionary_login = $_GET['questionary_login'];

    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_login`=?
            AND `user_id`!='$authorization_user_id'";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $questionary_login);
    $prepare->execute();

    $user_sql = $prepare->get_result();

    $prepare->close();

    $user_array = $user_sql->fetch_all(1);
    $count_user = $user_array[0]['count'];

    $json_data['count_user'] = $count_user;
}
elseif (isset($_GET['questionary_email']))
{
    $questionary_email = $_GET['questionary_email'];

    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_email`=?
            AND `user_id`!='$authorization_user_id'";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $questionary_email);
    $prepare->execute();

    $user_sql = $prepare->get_result();

    $prepare->close();

    $user_array = $user_sql->fetch_all(1);
    $count_user = $user_array[0]['count'];

    $json_data['count_user'] = $count_user;
}

print json_encode($json_data);