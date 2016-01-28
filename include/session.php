<?php

session_start();
session_regenerate_id();

$authorization_permission = 0;

if (isset($_SESSION['authorization_id']))
{
    $authorization_id           = $_SESSION['authorization_id'];
    $authorization_login        = $_SESSION['authorization_login'];
    $authorization_permission   = $_SESSION['authorization_permission'];
    $authorization_team_id      = $_SESSION['authorization_team_id'];
    $authorization_team_name    = $_SESSION['authorization_team_name'];
    $authorization_country_id   = $_SESSION['authorization_country_id'];
    $authorization_country_name = $_SESSION['authorization_country_name'];

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