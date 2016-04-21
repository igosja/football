<?php

include (__DIR__ . '/include/include.php');

if (!isset($_GET['num']) || !isset($authorization_user_id))
{
    redirect('forum.php');
}

$num_get = (int) $_GET['num'];

$sql = "SELECT `forumpost_forumtheme_id`
        FROM `forumpost`
        WHERE `forumpost_id`='$num_get'
        AND `forumpost_user_id`='$authorization_user_id'
        LIMIT 1";
$theme_sql = $mysqli->query($sql);

$count_theme = $theme_sql->num_rows;

if (0 == $count_theme)
{
    redirect('forum.php');
}

$theme_array = $theme_sql->fetch_all(MYSQLI_ASSOC);

$theme_id = $theme_array[0]['forumpost_forumtheme_id'];

$sql = "DELETE FROM `forumpost`
        WHERE `forumpost_id`='$num_get'
        AND `forumpost_user_id`='$authorization_user_id'
        LIMIT 1";
$mysqli->query($sql);

$_SESSION['message_class']  = 'success';
$_SESSION['message_text']   = 'Сообщение успешно удалено.';

redirect('forum_theme.php?num=' . $theme_id);