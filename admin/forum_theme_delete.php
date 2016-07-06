<?php

include (__DIR__ . '/../include/include.php');

if (!isset($_GET['num']) || !isset($authorization_user_id))
{
    redirect('forum.php');
}

$num_get = (int) $_GET['num'];

$sql = "SELECT `forumtheme_forumthemegroup_id`
        FROM `forumtheme`
        WHERE `forumtheme_id`='$num_get'
        LIMIT 1";
$group_sql = $mysqli->query($sql);

$count_group = $group_sql->num_rows;

if (0 == $count_group)
{
    redirect('forum.php');
}

$group_array = $group_sql->fetch_all(1);

$group_id = $group_array[0]['forumtheme_forumthemegroup_id'];

$sql = "DELETE FROM `forumpost`
        WHERE `forumpost_forumtheme_id`='$num_get'";
$mysqli->query($sql);

$sql = "DELETE FROM `forumtheme`
        WHERE `forumtheme_id`='$num_get'
        LIMIT 1";
$mysqli->query($sql);

redirect('forum_group.php?num=' . $group_id);