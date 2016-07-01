<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `count_post`,
               `count_theme`,
               `forumchapter_id`,
               `forumchapter_name`,
               `t3`.`forumpost_date` AS `forumpost_date`,
               `t5`.`forumtheme_id` AS `forumtheme_id`,
               `t5`.`forumtheme_name` AS `forumtheme_name`,
               `forumthemegroup_country_id`,
               `forumthemegroup_description`,
               `forumthemegroup_id`,
               `forumthemegroup_name`,
               `user_id`,
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
            SELECT MAX(`forumpost_date`) AS `forumpost_date`,
                   MAX(`forumpost_id`) AS `forumpost_id`,
                   `forumtheme_id`,
                   `forumtheme_name`,
                   `forumtheme_forumthemegroup_id`
            FROM `forumpost`
            LEFT JOIN `forumtheme`
            ON `forumtheme_id`=`forumpost_forumtheme_id`
            GROUP BY `forumtheme_forumthemegroup_id`
            ORDER BY `forumpost_id` DESC
        ) AS `t3`
        ON `t3`.`forumtheme_forumthemegroup_id`=`forumthemegroup_id`
        LEFT JOIN `forumpost` AS `t4`
        ON `t4`.`forumpost_id`=`t3`.`forumpost_id`
        LEFT JOIN `forumtheme` AS `t5`
        ON `t5`.`forumtheme_id`=`t4`.`forumpost_forumtheme_id`
        LEFT JOIN `user`
        ON `user_id`=`t4`.`forumpost_user_id`
        ORDER BY `forumchapter_id` ASC, `forumthemegroup_id` ASC";
$forum_sql = $mysqli->query($sql);

$count_forum = $forum_sql->num_rows;
$forum_array = $forum_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');