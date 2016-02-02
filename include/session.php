<?php

session_start();
session_regenerate_id();

$authorization_permission = 0;

if (isset($_SESSION['authorization_id']))
{
    $authorization_id           = $_SESSION['authorization_id'];
    $authorization_login        = $_SESSION['authorization_login'];

    $sql = "SELECT `country_id`,
                   `country_name`,
                   `team_id`,
                   `team_name`,
                   `user_id`,
                   `userrole_permission`
            FROM `user`
            LEFT JOIN `userrole`
            ON `user_userrole_id`=`userrole_id`
            LEFT JOIN `team`
            ON `team_user_id`=`user_id`
            LEFT JOIN `country`
            ON `country_user_id`=`user_id`
            WHERE `user_login`=?
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $authorization_login);
    $prepare->execute();

    $user_sql = $prepare->get_result();

    $prepare->close();

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    $authorization_user_id      = $user_array[0]['user_id'];
    $authorization_team_id      = $user_array[0]['team_id'];
    $authorization_team_name    = $user_array[0]['team_name'];
    $authorization_country_id   = $user_array[0]['country_id'];
    $authorization_country_name = $user_array[0]['country_name'];
    $user_permission            = $user_array[0]['userrole_permission'];

    $sql = "UPDATE `user`
            SET `user_last_visit`=SYSDATE()
            WHERE `user_id`='$authorization_id'
            LIMIT 1";
    $mysqli->query($sql);

    $sql = "SELECT COUNT(`inbox_id`) AS `count_inbox`
            FROM `inbox`
            WHERE `inbox_user_id`='$authorization_id'
            AND `inbox_read`='0'";
    $message_sql = $mysqli->query($sql);

    $message_array = $message_sql->fetch_all(MYSQLI_ASSOC);

    $count_message = $message_array[0]['count_inbox'];
}