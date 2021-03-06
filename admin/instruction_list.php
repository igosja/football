<?php

include (__DIR__ . '/../include/include.php');

if (isset($_GET['chapter_id']))
{
    $chapter_id = (int) $_GET['chapter_id'];

    $sql = "SELECT `instruction_id`,
                   `instruction_name`,
                   `instructionchapter_id`,
                   `instructionchapter_name`
            FROM `instruction` AS `t1`
            LEFT JOIN `instructionchapter`
            ON `instruction_instructionchapter_id`=`instructionchapter_id`
            WHERE `instructionchapter_id`='$chapter_id'
            ORDER BY `instruction_instructionchapter_id` ASC, `instruction_id` ASC";
}
else
{
    $sql = "SELECT `instruction_id`,
                   `instruction_name`,
                   `instructionchapter_id`,
                   `instructionchapter_name`
            FROM `instruction`
            LEFT JOIN `instructionchapter`
            ON `instruction_instructionchapter_id`=`instructionchapter_id`
            ORDER BY `instruction_instructionchapter_id` ASC, `instruction_id` ASC";
}

$instruction_sql = $mysqli->query($sql);

$instruction_array = $instruction_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');