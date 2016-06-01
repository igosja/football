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

if (isset($_POST['data']))
{
    $data = $_POST['data'];

    foreach ($data as $key => $value)
    {
        $statusnational_id  = (int) $value;
        $player_id          = (int) $key;

        $sql = "UPDATE `player`
                SET `player_statusnational_id`='$statusnational_id'
                WHERE `player_id`='$player_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены';

    redirect('team_team_player_international.php?num=' . $num_get);
}

$team_array = $team_sql->fetch_all(1);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `player_age`,
               `player_height`,
               `player_id`,
               `player_national_id`,
               `player_price`,
               `player_statusnational_id`,
               `player_weight`,
               `position_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `position`
        ON `player_position_id`=`position_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `country`
        ON `country_id`=`player_country_id`
        WHERE `team_id`='$num_get'";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(1);

$sql = "SELECT `statusnational_id`,
               `statusnational_name`
        FROM `statusnational`
        ORDER BY `statusnational_id` ASC";
$statusnational_sql = $mysqli->query($sql);

$statusnational_array = $statusnational_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $team_name;
$seo_title          = $header_title . '. Международные инструкции. ' . $seo_title;
$seo_description    = $header_title . '. Международные инструкции. ' . $seo_description;
$seo_keywords       = $header_title . ', международные инструкции, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');