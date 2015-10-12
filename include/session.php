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

    $sql = "UPDATE `user`
            SET `user_last_visit`=SYSDATE()
            WHERE `user_id`='$authorization_id'
            LIMIT 1";
    $mysqli->query($sql);

    $smarty->assign('authorization_id', $authorization_id);
    $smarty->assign('authorization_login', $authorization_login);
    $smarty->assign('authorization_team_id', $authorization_team_id);
    $smarty->assign('authorization_team_name', $authorization_team_name);
}

$smarty->assign('authorization_permission', $authorization_permission);