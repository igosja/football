<?php

include ('include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

if (isset($_GET['page']))
{
    $page = (int) $_GET['page'];
}
else
{
    $page = 1;
}

$limit  = 10;
$offset = ($page - 1) * $limit;

$sql = "SELECT `city_name`,
               `country_name`,
               `forumtheme_date`,
               `forumtheme_id`,
               `forumtheme_name`,
               `forumtheme_text`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`
        FROM `forumtheme`
        LEFT JOIN `user`
        ON `forumtheme_user_id`=`user_id`
        LEFT JOIN `team`
        ON `team_user_id`=`user_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `country_id`=`city_country_id`
        WHERE `forumtheme_id`='$get_num'
        LIMIT 1";
$head_sql = $mysqli->query($sql);

$head_array = $head_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `city_name`,
               `country_name`,
               `forumpost_date`,
               `forumpost_id`,
               `forumpost_name`,
               `forumpost_text`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`
        FROM `forumpost`
        LEFT JOIN `user`
        ON `forumpost_user_id`=`user_id`
        LEFT JOIN `team`
        ON `team_user_id`=`user_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `country_id`=`city_country_id`
        WHERE `forumpost_forumtheme_id`='$get_num'
        ORDER BY `forumpost_id` ASC
        LIMIT $offset, $limit";
$forum_sql = $mysqli->query($sql);

$count       = $forum_sql->num_rows;
$forum_array = $forum_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count_forum`";
$count_forum = $mysqli->query($sql);
$count_forum = $count_forum->fetch_all(MYSQLI_ASSOC);
$count_forum = $count_forum[0]['count_forum'];
$count_forum = ceil($count_forum / $limit);

$num            = $get_num;
$header_title   = 'Форум';

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');