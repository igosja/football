<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `count_theme`,
               `country_id`,
               `country_name`,
               `forumchapter_id`,
               `forumchapter_name`,
               `forumthemegroup_id`,
               `forumthemegroup_name`
        FROM `forumthemegroup` AS `t1`
        LEFT JOIN
        (
            SELECT COUNT(`forumtheme_forumthemegroup_id`) AS `count_theme`,
                   `forumtheme_forumthemegroup_id`
            FROM `forumtheme`
            GROUP BY `forumtheme_forumthemegroup_id`
        ) AS `t2`
        ON `t1`.`forumthemegroup_id`=`t2`.`forumtheme_forumthemegroup_id`
        LEFT JOIN `forumchapter`
        ON `forumchapter_id`=`forumthemegroup_forumchapter_id`
        LEFT JOIN `country`
        ON `country_id`=`forumthemegroup_country_id`
        ORDER BY `forumchapter_id` ASC, `forumthemegroup_id` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');