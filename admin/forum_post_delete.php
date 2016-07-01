<?php

include (__DIR__ . '/../include/include.php');

if (!isset($_GET['num']) || !isset($authorization_user_id))
{
    redirect('forum.php');
}

$num_get = (int) $_GET['num'];

$sql = "SELECT `forumpost_forumtheme_id`
        FROM `forumpost`
        WHERE `forumpost_id`='$num_get'
        LIMIT 1";
$theme_sql = $mysqli->query($sql);

$count_theme = $theme_sql->num_rows;

if (0 == $count_theme)
{
    redirect('forum.php');
}

$theme_array = $theme_sql->fetch_all(1);

$theme_id = $theme_array[0]['forumpost_forumtheme_id'];

$sql = "DELETE FROM `forumpost`
        WHERE `forumpost_id`='$num_get'
        LIMIT 1";
$mysqli->query($sql);

redirect('forum_theme.php?num=' . $theme_id);