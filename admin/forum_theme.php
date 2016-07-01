<?php

include (__DIR__ . '/../include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

if (isset($_GET['page']))
{
    $page = (int) $_GET['page'];
}
else
{
    $sql = "SELECT COUNT(`forumpost_id`) AS `count`
            FROM `forumpost`
            LEFT JOIN `forumtheme`
            ON `forumtheme_id`=`forumpost_forumtheme_id`
            WHERE `forumtheme_id`='$num_get'";
    $page_sql = $mysqli->query($sql);

    $page_array = $page_sql->fetch_all(1);
    $count_page = $page_array[0]['count'];
    $page       = ceil($count_page / 10);
}

if (1 > $page)
{
    $page = 1;
}

$limit  = 10;
$offset = ($page - 1) * $limit;

$sql = "SELECT `city_name`,
               `country_name`,
               `forumthemegroup_id`,
               `forumthemegroup_name`,
               `forumtheme_date`,
               `forumtheme_id`,
               `forumtheme_name`,
               `forumtheme_text`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`
        FROM `forumtheme`
        LEFT JOIN `forumthemegroup`
        ON `forumtheme_forumthemegroup_id`=`forumthemegroup_id`
        LEFT JOIN `user`
        ON `forumtheme_user_id`=`user_id`
        LEFT JOIN `team`
        ON `team_user_id`=`user_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `country_id`=`city_country_id`
        WHERE `forumtheme_id`='$num_get'
        LIMIT 1";
$head_sql = $mysqli->query($sql);

$count_head = $head_sql->num_rows;

if (0 == $count_head)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

$head_array = $head_sql->fetch_all(1);

$header_title   = $head_array[0]['forumtheme_name'];
$group_id       = $head_array[0]['forumthemegroup_id'];
$group_name     = $head_array[0]['forumthemegroup_name'];

$bread_array    = array(
                    array('url' => 'forum.php', 'text' => 'Форум'),
                    array('url' => 'forum_group.php?num=' . $group_id, 'text' => $group_name)
                  );
$bread_last     = $header_title;

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
        WHERE `forumpost_forumtheme_id`='$num_get'
        ORDER BY `forumpost_id` ASC
        LIMIT $offset, $limit";
$forum_sql = $mysqli->query($sql);

$count       = $forum_sql->num_rows;
$forum_array = $forum_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count_forum`";
$count_forum = $mysqli->query($sql);
$count_forum = $count_forum->fetch_all(1);
$count_forum = $count_forum[0]['count_forum'];
$count_forum = ceil($count_forum / $limit);

include (__DIR__ . '/../view/admin_main.php');