<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `attributechapterstaff_id`,
               `attributechapterstaff_name`,
               `count_attributestaff`
        FROM `attributechapterstaff` AS `t1`
        LEFT JOIN
        (
            SELECT `attributestaff_attributechapterstaff_id`,
                   COUNT(`attributestaff_attributechapterstaff_id`) AS `count_attributestaff`
            FROM `attributestaff`
            GROUP BY `attributestaff_attributechapterstaff_id`
        ) AS `t2`
        ON `t1`.`attributechapterstaff_id`=`t2`.`attributestaff_attributechapterstaff_id`
        ORDER BY `attributechapterstaff_id` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');

?>