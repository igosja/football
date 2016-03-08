<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
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
            WHERE `lineup_player_id`='$get_num'
            AND `game_played`='1'
            ORDER BY `shedule_date` DESC
            LIMIT 5
        ) AS `t1`
        ON `lineup_player_id`=`player_id`
        WHERE `player_id`='$get_num'
        LIMIT 1";
$player_sql = $mysqli->query($sql);

$count_player = $player_sql->num_rows;

if (0 == $count_player)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$player_name    = $player_array[0]['name_name'];
$player_surname = $player_array[0]['surname_name'];

if (isset($_GET['char']))
{
    $sql = "SELECT `user_money_training`
            FROM `user`
            WHERE `user_id`='$authorization_id'
            LIMIT 1";
    $user_sql = $mysqli->query($sql);

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    $user_money = $user_array[0]['user_money_training'];

    if (0 == $user_money)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'У вас нет доступных баллов для платной тренировки.';

        redirect('player_home_training.php?num=' . $get_num);
        exit;
    }

    $char = (int) $_GET['char'];

    $sql = "SELECT `attribute_name`,
                   `playerattribute_value`
            FROM `attribute`
            LEFT JOIN `playerattribute`
            ON `attribute_id`=`playerattribute_attribute_id`
            WHERE `attribute_id`='$char'
            AND `playerattribute_player_id`='$get_num'
            LIMIT 1";
    $attribute_sql = $mysqli->query($sql);

    $count_attribute = $attribute_sql->num_rows;

    if (0 == $count_attribute)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Характеристика выбрана неправильно.';

        redirect('player_home_training.php?num=' . $get_num);
        exit;
    }

    $attribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);
    $attribute_value = $attribute_array[0]['playerattribute_value'];

    if (100 <= $attribute_value)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Эта характеристика имеет максимальный уровень, больше ее увеличить нельзя.';

        redirect('player_home_training.php?num=' . $get_num);
        exit;
    }

    if (isset($_GET['ok']))
    {
        $sql = "UPDATE `playerattribute`
                SET `playerattribute_value`=`playerattribute_value`+'1'
                WHERE `playerattribute_attribute_id`='$char'
                AND `playerattribute_player_id`='$get_num'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `user`
                SET `user_money_training`=`user_money_training`-'1'
                WHERE `user_id`='$authorization_id'
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
                WHERE `player_id`='$get_num'";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Тренировка прошла успешно.';

        redirect('player_home_training.php?num=' . $get_num);
        exit;
    }

    $tpl            = 'submit_training';
    $num            = $get_num;
    $header_title   = $player_name . ' ' . $player_surname;

    include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');
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
        WHERE `playerattribute_player_id`='$get_num'
        ORDER BY `attributechapter_id` ASC, `attribute_id` ASC";
$attribute_sql = $mysqli->query($sql);

$count_attribute = $attribute_sql->num_rows;
$attribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $player_name . ' ' . $player_surname;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');
