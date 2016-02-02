<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['chapter_id']))
{
    $chapter_id     = (int) $_POST['chapter_id'];
    $instruction_name = $_POST['instruction_name'];

    $sql = "INSERT INTO `instruction`
            SET `instruction_name`=?,
                `instruction_instructionchapter_id`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $instruction_name, $chapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('instruction_list.php');

    exit;
}

$sql = "SELECT `instructionchapter_id`, `instructionchapter_name`
        FROM `instructionchapter`
        ORDER BY `instructionchapter_id` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(MYSQL_ASSOC);

$smarty->assign('chapter_array', $chapter_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');