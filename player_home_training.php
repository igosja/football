<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

if (!isset($authorization_team_id))
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$sql = "SELECT `country_id`,
               `country_name`,
               `mood_id`,
               `mood_name`,
               `name_name`,
               `player_age`,
               `player_condition`,
               `player_height`,
               `player_leg_left`,
               `player_leg_right`,
               `player_mark`,
               `player_practice`,
               `player_price`,
               `player_salary`,
               `player_weight`,
               `position_description`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `mood`
        ON `player_mood_id`=`mood_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `position`
        ON `player_position_id`=`position_id`
        LEFT JOIN
        (
            SELECT `lineup_player_id`, ROUND(AVG(`lineup_mark`),2) AS `player_mark`
            FROM `lineup`
            LEFT JOIN `game`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            WHERE `lineup_player_id`='$num_get'
            AND `game_played`='1'
            ORDER BY `shedule_date` DESC
            LIMIT 5
        ) AS `t1`
        ON `lineup_player_id`=`player_id`
        WHERE `player_id`='$num_get'
        AND `player_team_id`='$authorization_team_id'
        LIMIT 1";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$player_array = $player_sql->fetch_all(1);

$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];

$sql = "SELECT `user_money_position`,
               `user_money_training`
        FROM `user`
        WHERE `user_id`='$authorization_user_id'
        LIMIT 1";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(1);

if (isset($_GET['char']))
{
    $user_money = $user_array[0]['user_money_training'];

    if (0 == $user_money)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = '?? ?????? ?????? ?????????????????? ???????????? ?????? ?????????????? ????????????????????.';

        redirect('player_home_training.php?num=' . $num_get);
    }

    $char = (int) $_GET['char'];

    $sql = "SELECT `attribute_name`,
                   `playerattribute_value`
            FROM `attribute`
            LEFT JOIN `playerattribute`
            ON `attribute_id`=`playerattribute_attribute_id`
            WHERE `attribute_id`='$char'
            AND `playerattribute_player_id`='$num_get'
            LIMIT 1";
    $attribute_sql = $mysqli->query($sql);

    $count_attribute = $attribute_sql->num_rows;

    if (0 == $count_attribute)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = '???????????????????????????? ?????????????? ??????????????????????.';

        redirect('player_home_training.php?num=' . $num_get);
    }

    $attribute_array = $attribute_sql->fetch_all(1);
    $attribute_value = $attribute_array[0]['playerattribute_value'];

    if (100 <= $attribute_value)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = '?????? ???????????????????????????? ?????????? ???????????????????????? ??????????????, ???????????? ???? ?????????????????? ????????????.';

        redirect('player_home_training.php?num=' . $num_get);
    }

    if (isset($_GET['ok']))
    {
        $sql = "UPDATE `playerattribute`
                SET `playerattribute_value`=`playerattribute_value`+'1'
                WHERE `playerattribute_attribute_id`='$char'
                AND `playerattribute_player_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `user`
                SET `user_money_training`=`user_money_training`-'1'
                WHERE `user_id`='$authorization_user_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `player`
                LEFT JOIN
                (
                    SELECT `playerattribute_player_id`,
                           SUM(`playerattribute_value`) AS `power`
                    FROM `playerattribute`
                    GROUP BY `playerattribute_player_id`
                ) AS `t1`
                ON `player_id`=`playerattribute_player_id`
                SET `player_salary`=ROUND(POW(`power`, 1.3)),
                    `player_price`=`player_salary`*'987',
                    `player_reputation`=`power`/'" . MAX_PLAYER_POWER . "'*'100'
                WHERE `player_id`='$num_get'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = '???????????????????? ???????????? ??????????????.';

        redirect('player_home_training.php?num=' . $num_get);
    }

    $tpl            = 'submit_training';
    $num            = $num_get;
    $header_title   = $player_name . ' ' . $player_surname;

    include (__DIR__ . '/view/main.php');
    exit;
}
elseif (isset($_GET['position']))
{
    $user_money = $user_array[0]['user_money_position'];

    if (0 == $user_money)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = '?? ?????? ?????? ?????????????????? ???????????? ?????? ?????????????? ????????????????????.';

        redirect('player_home_training.php?num=' . $num_get);
    }

    $position = (int) $_GET['position'];

    $sql = "SELECT `position_description`
            FROM `position`
            WHERE `position_id`='$position'
            AND `position_available`='1'
            LIMIT 1";
    $position_sql = $mysqli->query($sql);

    $count_position = $position_sql->num_rows;

    if (0 == $count_position)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = '?????????????? ?????????????? ??????????????????????.';

        redirect('player_home_training.php?num=' . $num_get);
    }

    $position_array = $position_sql->fetch_all(1);

    $sql = "SELECT `playerposition_id`,
                   `playerposition_value`
            FROM `playerposition`
            WHERE `playerposition_position_id`='$position'
            AND `playerposition_player_id`='$num_get'
            LIMIT 1";
    $playerposition_sql = $mysqli->query($sql);

    $count_playerposition = $playerposition_sql->num_rows;

    if (0 < $count_playerposition)
    {
        $playerposition_array   = $playerposition_sql->fetch_all(1);
        $playerposition_value   = $playerposition_array[0]['playerposition_value'];
        $playerposition_id      = $playerposition_array[0]['playerposition_id'];

        if (100 <= $playerposition_value)
        {
            $_SESSION['message_class']  = 'error';
            $_SESSION['message_text']   = '?????????? ???????? ???? ???????? ?????????????? ?????????? ???????????????????????? ??????????????, ???????????? ?????? ?????????????????? ????????????.';

            redirect('player_home_training.php?num=' . $num_get);
        }
    }

    if (isset($_GET['ok']))
    {
        if (isset($playerposition_id))
        {
            $sql = "UPDATE `playerposition`
                    SET `playerposition_value`='100'
                    WHERE `playerposition_id`='$playerposition_id'
                    LIMIT 1";
            $mysqli->query($sql);
        }
        else
        {
            $sql = "INSERT INTO `playerposition`
                    SET `playerposition_value`='100',
                        `playerposition_position_id`='$position',
                        `playerposition_player_id`='$num_get'";
            $mysqli->query($sql);
        }

        $sql = "UPDATE `user`
                SET `user_money_position`=`user_money_position`-'1'
                WHERE `user_id`='$authorization_user_id'
                LIMIT 1";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = '???????????????????? ???????????? ??????????????.';

        redirect('player_home_training.php?num=' . $num_get);
    }

    $tpl            = 'submit_position';
    $num            = $num_get;
    $header_title   = $player_name . ' ' . $player_surname;

    include (__DIR__ . '/view/main.php');
    exit;
}

$sql = "SELECT `attribute_id`,
               `attribute_name`,
               `attributechapter_name`,
               `playerattribute_value`
        FROM `playerattribute`
        LEFT JOIN `attribute`
        ON `attribute_id`=`playerattribute_attribute_id`
        LEFT JOIN `attributechapter`
        ON `attributechapter_id`=`attribute_attributechapter_id`
        WHERE `playerattribute_player_id`='$num_get'
        ORDER BY `attributechapter_id` ASC, `attribute_id` ASC";
$attribute_sql = $mysqli->query($sql);

$count_attribute = $attribute_sql->num_rows;
$attribute_array = $attribute_sql->fetch_all(1);

$sql = "SELECT `playerposition_value`,
               `position_coordinate_x`,
               `position_coordinate_y`,
               `position_description`,
               `position_id`,
               `position_name`
        FROM `playerposition`
        LEFT JOIN `position`
        ON `position_id`=`playerposition_position_id`
        WHERE `playerposition_player_id`='$num_get'
        ORDER BY `playerposition_value` DESC";
$playerposition_sql = $mysqli->query($sql);

$playerposition_array = $playerposition_sql->fetch_all(1);

$sql = "SELECT `position_id`,
               `position_name`
        FROM `position`
        WHERE `position_id` NOT IN
        (
            SELECT `playerposition_position_id`
            FROM `playerposition`
            WHERE `playerposition_player_id`='$num_get'
        )
        AND `position_available`='1'
        ORDER BY `position_id` DESC";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $player_name . ' ' . $player_surname;
$seo_title          = $header_title . '. ???????????????????? ????????????????????. ' . $seo_title;
$seo_description    = $header_title . '. ???????????????????? ????????????????????. ' . $seo_description;
$seo_keywords       = $header_title . ', ???????????????????? ????????????????????, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');
