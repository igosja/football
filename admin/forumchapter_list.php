<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `forumchapter_id`,
               `forumchapter_name`,
               `count_group`
        FROM `forumchapter` AS `t1`
        LEFT JOIN
        (
            SELECT `forumthemegroup_forumchapter_id`,
                   COUNT(`forumthemegroup_forumchapter_id`) AS `count_group`
            FROM `forumthemegroup`
            GROUP BY `forumthemegroup_forumchapter_id`
        ) AS `t2`
        ON `t1`.`forumchapter_id`=`t2`.`forumthemegroup_forumchapter_id`
        ORDER BY `forumchapter_id` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(MYSQLI_ASSOC);

include (__DIR__ . '/../view/admin_main.php');