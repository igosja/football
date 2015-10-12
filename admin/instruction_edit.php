<?php

include ('../include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `instruction_instructionchapter_id`, `instruction_name`
        FROM `instruction`
        WHERE `instruction_id`='$get_num'
        LIMIT 1";
$instruction_sql = $mysqli->query($sql);

$count_instruction = $instruction_sql->num_rows;

if (0 == $count_instruction)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['chapter_id']))
{
    $chapter_id     = (int) $_POST['chapter_id'];
    $instruction_name = $_POST['instruction_name'];

    $sql = "UPDATE `instruction` 
            SET `instruction_name`=?, 
                `instruction_instructionchapter_id`=?
            WHERE `instruction_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $instruction_name, $chapter_id);
    $prepare->execute();
    $prepare->close();

    redirect('instruction_list.php');

    exit;
}

$instruction_array = $instruction_sql->fetch_all(MYSQLI_ASSOC);

$instruction_name = $instruction_array[0]['instruction_name'];
$chapter_id     = $instruction_array[0]['instruction_instructionchapter_id'];

$sql = "SELECT `instructionchapter_id`, `instructionchapter_name`
        FROM `instructionchapter`
        ORDER BY `instructionchapter_id` ASC";
$chapter_sql = $mysqli->query($sql);

$chapter_array = $chapter_sql->fetch_all(MYSQL_ASSOC);

$smarty->assign('chapter_array', $chapter_array);
$smarty->assign('instruction_name', $instruction_name);
$smarty->assign('chapter_id', $chapter_id);
$smarty->assign('tpl', 'instruction_create');

$smarty->display('admin_main.html');