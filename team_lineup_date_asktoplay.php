<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_team_id))
{
    $num_get = $authorization_team_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

if (isset($_GET['ok']))
{
    $asktoplay_id   = (int) $_GET['ok'];
    $shedule_id     = (int) $_GET['shedule'];
    $team_id        = (int) $_GET['team'];

    $sql = "SELECT COUNT(`game_id`) AS `count`
            FROM `game`
            WHERE (`game_home_team_id`='$num_get'
            OR `game_guest_team_id`='$num_get')
            AND `game_shedule_id`='$shedule_id'";
    $check_sql = $mysqli->query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);
    $count_check = $check_array[0]['count'];

    if (0 != $count_check)
    {
        $sql = "DELETE FROM `asktoplay`
                WHERE (`asktoplay_invitee_team_id`='$num_get'
                OR `asktoplay_inviter_team_id`='$num_get')
                AND `asktoplay_shedule_id`='$shedule_id'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Вы уже играете матч в этот день.';

        redirect('team_lineup_date_asktoplay.php?num=' . $num_get);
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

        $sql = "DELETE FROM `inbox`
                WHERE `inbox_asktoplay_id`='$asktoplay_id'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Ваш соперник уже играет матч в этот день.';

        redirect('team_lineup_date_asktoplay.php?num=' . $num_get);
    }

    $sql = "SELECT `asktoplay_home`,
                   `team_user_id`
            FROM `asktoplay`
            LEFT JOIN `team`
            ON `team_id`=`asktoplay_inviter_team_id`
            WHERE `asktoplay_invitee_team_id`='$num_get'
            AND `asktoplay_inviter_team_id`='$team_id'
            AND `asktoplay_shedule_id`='$shedule_id'
            ORDER BY `asktoplay_id` ASC";
    $asktoplay_sql = $mysqli->query($sql);

    $count_asktoplay = $asktoplay_sql->num_rows;

    if (0 != $count_asktoplay)
    {
        $asktoplay_array = $asktoplay_sql->fetch_all(MYSQLI_ASSOC);

        $asktoplay_home = $asktoplay_array[0]['asktoplay_home'];
        $user_id        = $asktoplay_array[0]['team_user_id'];

        $sql = "SELECT `referee_id`
                FROM `referee`
                WHERE `referee_id` NOT IN
                (
                    SELECT `game_referee_id`
                    FROM `game`
                    WHERE `game_shedule_id`='$shedule_id'
                )
                ORDER BY RAND()
                LIMIT 1";
        $referee_sql = $mysqli->query($sql);

        $referee_array = $referee_sql->fetch_all(MYSQLI_ASSOC);

        $referee_id = $referee_array[0]['referee_id'];

        if (1 == $asktoplay_home)
        {
            $sql = "INSERT INTO `game`
                    SET `game_guest_team_id`='$num_get',
                        `game_home_team_id`='$team_id',
                        `game_shedule_id`='$shedule_id',
                        `game_referee_id`='$referee_id',
                        `game_stadium_id`='$team_id',
                        `game_tournament_id`='1'";
        }
        else
        {
            $sql = "INSERT INTO `game`
                    SET `game_guest_team_id`='$team_id',
                        `game_home_team_id`='$num_get',
                        `game_shedule_id`='$shedule_id',
                        `game_referee_id`='$referee_id',
                        `game_stadium_id`='$num_get',
                        `game_tournament_id`='1'";
        }

        $mysqli->query($sql);

        $sql = "SELECT `inboxtheme_name`,
                       `inboxtheme_text`
                FROM `inboxtheme`
                WHERE `inboxtheme_id`='" . INBOXTHEME_ASKTOPLAY_YES . "'
                LIMIT 1";
        $inboxtheme_sql = $mysqli->query($sql);

        $inboxtheme_array = $inboxtheme_sql->fetch_all(MYSQLI_ASSOC);

        $inboxtheme_name = $inboxtheme_array[0]['inboxtheme_name'];
        $inboxtheme_text = $inboxtheme_array[0]['inboxtheme_text'];
        $inboxtheme_text = sprintf($inboxtheme_text, $authorization_team_name);

        $sql = "INSERT INTO `inbox`
                SET `inbox_asktoplay_id`='$asktoplay_id',
                    `inbox_date`=UNIX_TIMESTAMP(),
                    `inbox_inboxtheme_id`='" . INBOXTHEME_ASKTOPLAY_YES . "',
                    `inbox_sender_id`='$authorization_id',
                    `inbox_title`='$inboxtheme_name',
                    `inbox_text`='$inboxtheme_text',
                    `inbox_user_id`='$user_id'";
        $mysqli->query($sql);

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

        $sql = "SELECT `asktoplay_id`,
                       `team_user_id`
                FROM `asktoplay`
                LEFT JOIN `team`
                ON `team_id`=`asktoplay_inviter_team_id`
                WHERE (`asktoplay_invitee_team_id`='$num_get'
                OR `asktoplay_inviter_team_id`='$num_get')
                AND `asktoplay_shedule_id`='$shedule_id'
                AND `asktoplay_id`!='$asktoplay_id'";
        $asktoplay_sql = $mysqli->query($sql);

        $count_asktoplay = $asktoplay_sql->num_rows;

        $asktoplay_array = $asktoplay_sql->fetch_all(MYSQLI_ASSOC);

        for ($i=0; $i<$count_asktoplay; $i++)
        {
            $asktoplay_id = $asktoplay_array[$i]['asktoplay_id'];
            $user_id      = $asktoplay_array[$i]['team_user_id'];

            $sql = "DELETE FROM `asktoplay`
                    WHERE `asktoplay_id`='$asktoplay_id'";
            $mysqli->query($sql);

            if($authorization_user_id != $user_id)
            {
                $sql = "INSERT INTO `inbox`
                        SET `inbox_asktoplay_id`='$asktoplay_id',
                            `inbox_date`=UNIX_TIMESTAMP(),
                            `inbox_inboxtheme_id`='" . INBOXTHEME_ASKTOPLAY_YES . "',
                            `inbox_sender_id`='$authorization_user_id',
                            `inbox_title`='$inboxtheme_name',
                            `inbox_text`='$inboxtheme_text',
                            `inbox_user_id`='$user_id'";
                $mysqli->query($sql);
            }
        }

        $sql = "SELECT `asktoplay_id`
                FROM `asktoplay`
                WHERE (`asktoplay_invitee_team_id`='$team_id'
                OR `asktoplay_inviter_team_id`='$team_id')
                AND `asktoplay_shedule_id`='$shedule_id'";
        $asktoplay_sql = $mysqli->query($sql);

        $count_asktoplay = $asktoplay_sql->num_rows;

        $asktoplay_array = $asktoplay_sql->fetch_all(MYSQLI_ASSOC);

        for ($i=0; $i<$count_asktoplay; $i++)
        {
            $asktoplay_id = $asktoplay_array[$i]['asktoplay_id'];

            $sql = "DELETE FROM `asktoplay`
                    WHERE `asktoplay_id`='$asktoplay_id'";
            $mysqli->query($sql);
        }

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Матч успешно организован.';

        redirect('team_lineup_date_asktoplay.php?num=' . $num_get);
    }
}

$sql = "SELECT `asktoplay_shedule_id`,
               `shedule_date`,
               `shedule_id`,
               `shedule_tournamenttype_id`,
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
            ON IF (`game_home_team_id`='$num_get', `game_guest_team_id`=`team_id`, `game_home_team_id`=`team_id`)
            LEFT JOIN `tournament`
            ON `game_tournament_id`=`tournament_id`
            WHERE (`game_home_team_id`='$num_get'
            OR `game_guest_team_id`='$num_get')
        ) AS `t1`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN
        (
            SELECT `asktoplay_shedule_id`
            FROM `asktoplay`
            WHERE `asktoplay_invitee_team_id`='$num_get'
            GROUP BY `asktoplay_shedule_id`
        ) AS `t2`
        ON `shedule_id`=`asktoplay_shedule_id`
        WHERE `shedule_season_id`='$igosja_season_id'
        AND `shedule_tournamenttype_id`!='" . TOURNAMENT_TYPE_OFF_SEASON . "'
        AND `shedule_date`>CURDATE()
        ORDER BY `shedule_date` ASC";
$shedule_sql = $mysqli->query($sql);

$shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `cupparticipant_out`
        FROM `cupparticipant`
        WHERE `cupparticipant_team_id`='$num_get'
        AND `cupparticipant_season_id`='$igosja_season_id'
        LIMIT 1";
$cupparticipant_sql = $mysqli->query($sql);

$cupparticipant_array = $cupparticipant_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `leagueparticipant_out`
        FROM `leagueparticipant`
        WHERE `leagueparticipant_team_id`='$num_get'
        AND `leagueparticipant_season_id`='$igosja_season_id'
        LIMIT 1";
$leagueparticipant_sql = $mysqli->query($sql);

$leagueparticipant_array = $leagueparticipant_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $team_name;
$seo_title          = $header_title . '. Товарищеские матчи. ' . $seo_title;
$seo_description    = $header_title . '. Товарищеские матчи. ' . $seo_description;
$seo_keywords       = $header_title . ', товарищеские матчи, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');