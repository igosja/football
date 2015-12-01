<?php

include ('include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    $smarty->display('only_my_team.html');
    exit;
}

if (isset($_GET['ok']))
{
    $askroplay_id   = (int) $_GET['ok'];
    $shedule_id     = (int) $_GET['shedule'];
    $team_id        = (int) $_GET['team'];

    $sql = "SELECT COUNT(`game_id`) AS `count`
            FROM `game`
            WHERE (`game_home_team_id`='$get_num'
            OR `game_guest_team_id`='$get_num')
            AND `game_shedule_id`='$shedule_id'";
    $check_sql = $mysqli->query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);
    $count_check = $check_array[0]['count'];

    if (0 != $count_check)
    {
        $sql = "DELETE FROM `asktoplay`
                WHERE (`asktoplay_invitee_team_id`='$get_num'
                OR `asktoplay_inviter_team_id`='$get_num')
                AND `asktoplay_shedule_id`='$shedule_id'";
        $mysqli->query($sql);

        redirect('asktoplay.php');
        exit;
    }

    $sql = "SELECT COUNT(`game_id`) AS `count`
            FROM `game`
            WHERE (`game_home_team_id`='$team_id'
            OR `game_guest_team_id`='$team_id')
            AND `game_shedule_id`='$shedule_id'";
    $check_sql = $mysqli->query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);
    $count_check = $check_array[0]['count'];

    if (0 != $count_check)
    {
        $sql = "DELETE FROM `asktoplay`
                WHERE (`asktoplay_invitee_team_id`='$team_id'
                OR `asktoplay_inviter_team_id`='$team_id')
                AND `asktoplay_shedule_id`='$shedule_id'";
        $mysqli->query($sql);

        redirect('asktoplay.php');
        exit;
    }

    $sql = "SELECT `asktoplay_home`
            FROM `asktoplay`
            WHERE `asktoplay_invitee_team_id`='$get_num'
            AND `asktoplay_inviter_team_id`='$team_id'
            AND `asktoplay_shedule_id`='$shedule_id'";
    $asktoplay_sql = $mysqli->query($sql);

    $count_asktoplay = $asktoplay_sql->num_rows;

    if (0 != $count_asktoplay)
    {
        $asktoplay_array = $asktoplay_sql->fetch_all(MYSQLI_ASSOC);

        $asktoplay_home = $asktoplay_array[0]['asktoplay_home'];

        if (1 == $asktoplay_home)
        {
            $sql = "INSERT INTO `game`
                    SET `game_guest_team_id`='$get_num',
                        `game_home_team_id`='$team_id',
                        `game_shedule_id`='$shedule_id',
                        `game_referee_id`='1',
                        `game_stadium_id`='$team_id',
                        `game_tournament_id`='1'";
        }
        else
        {
            $sql = "INSERT INTO `game`
                    SET `game_guest_team_id`='$team_id',
                        `game_home_team_id`='$get_num',
                        `game_shedule_id`='$shedule_id',
                        `game_referee_id`='1',
                        `game_stadium_id`='$get_num',
                        `game_tournament_id`='1'";
        }

        $mysqli->query($sql);

        $sql = "DELETE FROM `asktoplay`
                WHERE (`asktoplay_invitee_team_id`='$get_num'
                OR `asktoplay_inviter_team_id`='$get_num')
                AND `asktoplay_shedule_id`='$shedule_id'";
        $mysqli->query($sql);

        $sql = "DELETE FROM `asktoplay`
                WHERE (`asktoplay_invitee_team_id`='$team_id'
                OR `asktoplay_inviter_team_id`='$team_id')
                AND `asktoplay_shedule_id`='$shedule_id'";
        $mysqli->query($sql);

        redirect('asktoplay.php');
        exit;
    }
}

$sql = "SELECT `asktoplay_shedule_id`,
               `shedule_date`,
               `shedule_id`,
               `team_id`,
               `team_name`,
               `tournament_id`,
               `tournament_name`
        FROM `shedule`
        LEFT JOIN
        (
            SELECT `game_shedule_id`,
                   `team_id`,
                   `team_name`,
                   `tournament_id`,
                   `tournament_name`
            FROM `game`
            LEFT JOIN `team`
            ON IF (`game_home_team_id`='$get_num', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
            LEFT JOIN `tournament`
            ON `game_tournament_id`=`tournament_id`
            WHERE (`game_home_team_id`='$get_num'
            OR `game_guest_team_id`='$get_num')
        ) AS `t1`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN
        (
            SELECT `asktoplay_shedule_id`
            FROM `asktoplay`
            WHERE `asktoplay_invitee_team_id`='$get_num'
            GROUP BY `asktoplay_shedule_id`
        ) AS `t2`
        ON `shedule_id`=`asktoplay_shedule_id`
        WHERE `shedule_season_id`='$igosja_season_id'
        AND `shedule_date`>=CURDATE()
        ORDER BY `shedule_date` ASC";
$shedule_sql = $mysqli->query($sql);

$shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('shedule_array', $shedule_array);

$smarty->display('main.html');