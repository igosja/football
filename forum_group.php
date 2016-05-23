<?php

include (__DIR__ . '/include/include.php');

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
    $page = 1;
}

$limit  = 20;
$offset = ($page - 1) * $limit;

$sql = "SELECT `forumthemegroup_id`,
               `forumthemegroup_name`,
               `forumthemegroup_country_id`
        FROM `forumthemegroup`
        WHERE `forumthemegroup_id`='$num_get'
        LIMIT 1";
$head_sql = $mysqli->query($sql);

$count_head = $head_sql->num_rows;

if (0 == $count_head)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$head_array = $head_sql->fetch_all(MYSQLI_ASSOC);

$forumthemegroup_country_id = $head_array[0]['forumthemegroup_country_id'];

if (0 != $forumthemegroup_country_id &&
    (!isset($authorization_forumcountry_id) ||
    $authorization_forumcountry_id != $forumthemegroup_country_id))
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$header_title   = $head_array[0]['forumthemegroup_name'];
$bread_array    = array(array('url' => 'forum.php', 'text' => 'Форум'));
$bread_last     = $header_title;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `count_post`,
               `forumpost_date`,
               `t2`.`forumpost_id` AS `forumpost_id`,
               `forumtheme_date`,
               `forumtheme_id`,
               `forumtheme_name`,
               `post_id`,
               `post_login`,
               `user_id`,
               `user_login`
        FROM `forumtheme`
        LEFT JOIN `user`
        ON `user_id`=`forumtheme_user_id`
        LEFT JOIN
        (
            SELECT COUNT(`forumpost_id`) AS `count_post`,
                   `forumpost_forumtheme_id`
            FROM `forumpost`
            GROUP BY `forumpost_forumtheme_id`
        ) AS `t1`
        ON `t1`.`forumpost_forumtheme_id`=`forumtheme_id`
        LEFT JOIN
        (
            SELECT MAX(`forumpost_date`) AS `forumpost_date`,
                   MAX(`forumpost_id`) AS `forumpost_id`,
                   `forumpost_forumtheme_id`
            FROM `forumpost`
            GROUP BY `forumpost_forumtheme_id`
            ORDER BY `forumpost_id` DESC
        ) AS `t2`
        ON `t2`.`forumpost_forumtheme_id`=`forumtheme_id`
        LEFT JOIN
        (
            SELECT `user_id` AS `post_id`,
                   `user_login` AS `post_login`,
                   `forumpost_id`
            FROM `forumpost`
            LEFT JOIN `user`
            ON `forumpost_user_id`=`user_id`
        ) AS `t3`
        ON `t3`.`forumpost_id`=`t2`.`forumpost_id`
        WHERE `forumtheme_forumthemegroup_id`='$num_get'
        ORDER BY `forumpost_id` DESC
        LIMIT $offset, $limit";
$forum_sql = $mysqli->query($sql);

$forum_array = $forum_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count_forum`";

$count_forum = $mysqli->query($sql);
$count_forum = $count_forum->fetch_all(MYSQLI_ASSOC);
$count_forum = $count_forum[0]['count_forum'];
$count_forum = ceil($count_forum / $limit);

if (isset($authorization_user_id))
{
    $sql = "SELECT `forumread_forumpost_id`,
                   `forumread_forumtheme_id`
            FROM `forumread`
            LEFT JOIN `forumtheme`
            ON `forumtheme_id`=`forumread_forumtheme_id`
            WHERE `forumread_user_id`='$authorization_user_id'
            AND `forumtheme_forumthemegroup_id`='$num_get'
            ORDER BY `forumread_id`";
    $forumread_sql = $mysqli->query($sql);

    $forumread_array = $forumread_sql->fetch_all(MYSQLI_ASSOC);
}

$num                = $num_get;
$seo_title          = $header_title . '. Форум. ' . $seo_title;
$seo_description    = $header_title . '. Форум. ' . $seo_description;
$seo_keywords       = $header_title . ', Форум, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');