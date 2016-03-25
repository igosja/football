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

$sql = "SELECT `seriestype_name`
        FROM `seriestype`
        WHERE `seriestype_id`='$get_num'
        LIMIT 1";
$seriestype_sql = $mysqli->query($sql);

$count_seriestype = $seriestype_sql->num_rows;

if (0 == $count_seriestype)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['seriestype_name']))
{
    $seriestype_name = $_POST['seriestype_name'];

    $sql = "UPDATE `seriestype` 
            SET `seriestype_name`=?
            WHERE `seriestype_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $seriestype_name);
    $prepare->execute();
    $prepare->close();

    redirect('seriestype_list.php');
}

$seriestype_array = $seriestype_sql->fetch_all(MYSQLI_ASSOC);

$seriestype_name = $seriestype_array[0]['seriestype_name'];

$smarty->assign('seriestype_name', $seriestype_name);
$smarty->assign('tpl', 'seriestype_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');