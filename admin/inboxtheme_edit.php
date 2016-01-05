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

$sql = "SELECT `inboxtheme_name`,
               `inboxtheme_text`
        FROM `inboxtheme`
        WHERE `inboxtheme_id`='$get_num'
        LIMIT 1";
$inboxtheme_sql = $mysqli->query($sql);

$count_inboxtheme = $inboxtheme_sql->num_rows;

if (0 == $count_inboxtheme)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['inboxtheme_name']))
{
    $inboxtheme_name = $_POST['inboxtheme_name'];
    $inboxtheme_text = $_POST['inboxtheme_text'];

    $sql = "UPDATE `inboxtheme` 
            SET `inboxtheme_name`=?,
                `inboxtheme_text`=?
            WHERE `inboxtheme_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $inboxtheme_name, $inboxtheme_text);
    $prepare->execute();
    $prepare->close();

    redirect('inboxtheme_list.php');

    exit;
}

$inboxtheme_array = $inboxtheme_sql->fetch_all(MYSQLI_ASSOC);

$inboxtheme_name = $inboxtheme_array[0]['inboxtheme_name'];
$inboxtheme_text = $inboxtheme_array[0]['inboxtheme_text'];

$smarty->assign('inboxtheme_name', $inboxtheme_name);
$smarty->assign('inboxtheme_text', $inboxtheme_text);
$smarty->assign('tpl', 'inboxtheme_create');

$smarty->display('admin_main.html');