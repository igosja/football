<?php

include (__DIR__ . '/include/include.php');

if (!isset($authorization_team_id))
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

if (isset($authorization_user_id))
{
    $num_get = $authorization_user_id;
}
else
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

if (isset($_GET['ok']))
{
    $sql = "UPDATE `team`
            SET `team_user_id`='0'
            WHERE `team_id`='$authorization_team_id'
            LIMIT 1";
    $mysqli->query($sql);

    $sql = "UPDATE `user`
            SET `user_change_team`='1'
            WHERE `user_id`='$authorization_user_id'
            LIMIT 1";
    $mysqli->query($sql);

    f_igosja_history(HISTORY_TEXT_LOST_TEAM, $authorization_user_id, 0, $authorization_team_id);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Вы успешно отказались от команды.';

    redirect('profile_home_home.php');
}

$header_title       = $authorization_login;
$seo_title          = $header_title . '. Отказ от команды. ' . $seo_title;
$seo_description    = $header_title . '. Отказ от команды. ' . $seo_description;
$seo_keywords       = $header_title . ', Отказ от команды, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');
