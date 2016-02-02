<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['chapter_id']))
{
    $chapter_id = (int) $_GET['chapter_id'];

    $sql = "SELECT `instruction_id`, `instruction_name`, `instructionchapter_id`, `instructionchapter_name`
            FROM `instruction` AS `t1`
            LEFT JOIN
            (
                SELECT `instructionchapter_id`, `instructionchapter_name`
                FROM `instructionchapter`
            ) AS `t2`
            ON `t1`.`instruction_instructionchapter_id`=`t2`.`instructionchapter_id`
            WHERE `instructionchapter_id`='$chapter_id'
            ORDER BY `instruction_instructionchapter_id` ASC, `instruction_id` ASC";
}
else
{
    $sql = "SELECT `instruction_id`, `instruction_name`, `instructionchapter_id`, `instructionchapter_name`
            FROM `instruction` AS `t1`
            LEFT JOIN
            (
                SELECT `instructionchapter_id`, `instructionchapter_name`
                FROM `instructionchapter`
            ) AS `t2`
            ON `t1`.`instruction_instructionchapter_id`=`t2`.`instructionchapter_id`
            ORDER BY `instruction_instructionchapter_id` ASC, `instruction_id` ASC";
}

$instruction_sql = $mysqli->query($sql);

$instruction_array = $instruction_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('instruction_array', $instruction_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');