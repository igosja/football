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

$sql = "SELECT `gamestyle_description`, `gamestyle_name`
        FROM `gamestyle`
        WHERE `gamestyle_id`='$get_num'
        LIMIT 1";
$gamestyle_sql = $mysqli->query($sql);

$count_gamestyle = $gamestyle_sql->num_rows;

if (0 == $count_gamestyle)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['gamestyle_name']))
{
    $gamestyle_name          = $_POST['gamestyle_name'];
    $gamestyle_description   = $_POST['gamestyle_description'];

    $sql = "UPDATE `gamestyle` 
            SET `gamestyle_name`=?,
                `gamestyle_description`=?
            WHERE `gamestyle_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $gamestyle_name, $gamestyle_description);
    $prepare->execute();
    $prepare->close();

    redirect('gamestyle_list.php');

    exit;
}

$gamestyle_array = $gamestyle_sql->fetch_all(MYSQLI_ASSOC);

$gamestyle_name          = $gamestyle_array[0]['gamestyle_name'];
$gamestyle_description   = $gamestyle_array[0]['gamestyle_description'];

$smarty->assign('gamestyle_name', $gamestyle_name);
$smarty->assign('gamestyle_description', $gamestyle_description);
$smarty->assign('tpl', 'gamestyle_create');

$smarty->display('admin_main.html');