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

$limit  = 20;
$offset = ($page - 1) * $limit;

$sql = "SELECT `forumthemegroup_id`,
               `forumthemegroup_name`
        FROM `forumthemegroup`
        WHERE `forumthemegroup_id`='$get_num'
        LIMIT 1";
$head_sql = $mysqli->query($sql);

$head_array = $head_sql->fetch_all(MYSQLI_ASSOC);

$header_title = $head_array[0]['forumthemegroup_name'];

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `count_post`,
               `forumpost_date`,
               `forumtheme_date`,
               `forumtheme_id`,
               `forumtheme_name`,
               `post_login`,
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
            SELECT `forumpost_date`,
                   `forumpost_forumtheme_id`,
                   `user_login` AS `post_login`
            FROM `forumpost`
            LEFT JOIN `user`
            ON `user_id`=`forumpost_user_id`
            GROUP BY `forumpost_forumtheme_id`
            ORDER BY `forumpost_id` DESC
        ) AS `t2`
        ON `t2`.`forumpost_forumtheme_id`=`forumtheme_id`
        WHERE `forumtheme_forumthemegroup_id`='$get_num'
        ORDER BY `forumtheme_id` ASC
        LIMIT $offset, $limit";
$forum_sql = $mysqli->query($sql);

$forum_array = $forum_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count_forum`";

$count_forum = $mysqli->query($sql);
$count_forum = $count_forum->fetch_all(MYSQLI_ASSOC);
$count_forum = $count_forum[0]['count_forum'];
$count_forum = ceil($count_forum / $limit);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', 'Форум');
$smarty->assign('page', $page);
$smarty->assign('count_forum', $count_forum);
$smarty->assign('forum_array', $forum_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.html');