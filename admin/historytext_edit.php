<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `historytext_name`
        FROM `historytext`
        WHERE `historytext_id`='$get_num'
        LIMIT 1";
$historytext_sql = $mysqli->query($sql);

$count_historytext = $historytext_sql->num_rows;

if (0 == $count_historytext)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['historytext_name']))
{
    $historytext_name = $_POST['historytext_name'];

    $sql = "UPDATE `historytext` 
            SET `historytext_name`=?
            WHERE `historytext_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $historytext_name);
    $prepare->execute();
    $prepare->close();

    redirect('historytext_list.php');

    exit;
}

$historytext_array = $historytext_sql->fetch_all(MYSQLI_ASSOC);

$historytext_name = $historytext_array[0]['historytext_name'];

$smarty->assign('historytext_name', $historytext_name);
$smarty->assign('tpl', 'historytext_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');