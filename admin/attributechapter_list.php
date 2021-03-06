<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `attributechapter_id`,
               `attributechapter_name`,
               `count_attribute`
        FROM `attributechapter` AS `t1`
        LEFT JOIN
        (
            SELECT `attribute_attributechapter_id`,
                    COUNT(`attribute_attributechapter_id`) AS `count_attribute`
            FROM `attribute`
            GROUP BY `attribute_attributechapter_id`
        ) AS `t2`
        ON `t1`.`attributechapter_id`=`t2`.`attribute_attributechapter_id`
        ORDER BY `attributechapter_id` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');