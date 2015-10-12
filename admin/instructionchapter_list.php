<?php

include ('../include/include.php');

$sql = "SELECT `instructionchapter_id`, `instructionchapter_name`, `count_instruction`
        FROM `instructionchapter` AS `t1`
        LEFT JOIN
        (
            SELECT `instruction_instructionchapter_id`, COUNT(`instruction_instructionchapter_id`) AS `count_instruction`
            FROM `instruction`
            GROUP BY `instruction_instructionchapter_id`
        ) AS `t2`
        ON `t1`.`instructionchapter_id`=`t2`.`instruction_instructionchapter_id`
        ORDER BY `instructionchapter_id` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('chapter_array', $chapter_array);

$smarty->display('admin_main.html');