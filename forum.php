<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `count_post`,
               `count_theme`,
               `forumchapter_id`,
               `forumchapter_name`,
               `forumpost_date`,
               `forumtheme_id`,
               `forumtheme_name`,
               `forumthemegroup_description`,
               `forumthemegroup_id`,
               `forumthemegroup_name`,
               `user_login`
        FROM `forumthemegroup`
        LEFT JOIN `forumchapter`
        ON `forumchapter_id`=`forumthemegroup_forumchapter_id`
        LEFT JOIN
        (
            SELECT COUNT(`forumtheme_id`) AS `count_theme`,
                   `forumtheme_forumthemegroup_id`
            FROM `forumtheme`
            GROUP BY `forumtheme_forumthemegroup_id`
        ) AS `t1`
        ON `t1`.`forumtheme_forumthemegroup_id`=`forumthemegroup_id`
        LEFT JOIN
        (
            SELECT COUNT(`forumpost_id`) AS `count_post`,
                   `forumtheme_forumthemegroup_id`
            FROM `forumpost`
            LEFT JOIN `forumtheme`
            ON `forumtheme_id`=`forumpost_forumtheme_id`
            GROUP BY `forumtheme_forumthemegroup_id`
        ) AS `t2`
        ON `t2`.`forumtheme_forumthemegroup_id`=`forumthemegroup_id`
        LEFT JOIN
        (
            SELECT `forumpost_date`,
                   `forumtheme_id`,
                   `forumtheme_name`,
                   `forumtheme_forumthemegroup_id`,
                   `user_login`
            FROM `forumpost`
            LEFT JOIN `user`
            ON `user_id`=`forumpost_user_id`
            LEFT JOIN `forumtheme`
            ON `forumtheme_id`=`forumpost_forumtheme_id`
            GROUP BY `forumtheme_forumthemegroup_id`
            ORDER BY `forumpost_id` DESC
        ) AS `t3`
        ON `t3`.`forumtheme_forumthemegroup_id`=`forumthemegroup_id`
        ORDER BY `forumchapter_id` ASC, `forumthemegroup_id` ASC";
$forum_sql = $mysqli->query($sql);

$count_forum = $forum_sql->num_rows;
$forum_array = $forum_sql->fetch_all(MYSQLI_ASSOC);

$header_title = 'Форум';

include (__DIR__ . '/view/main.php');