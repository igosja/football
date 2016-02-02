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

$sql = "SELECT `gamemood_description`, `gamemood_name`
        FROM `gamemood`
        WHERE `gamemood_id`='$get_num'
        LIMIT 1";
$gamemood_sql = $mysqli->query($sql);

$count_gamemood = $gamemood_sql->num_rows;

if (0 == $count_gamemood)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/wrong_page.html');

    exit;
}

if (isset($_POST['gamemood_name']))
{
    $gamemood_name          = $_POST['gamemood_name'];
    $gamemood_description   = $_POST['gamemood_description'];

    $sql = "UPDATE `gamemood` 
            SET `gamemood_name`=?,
                `gamemood_description`=?
            WHERE `gamemood_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $gamemood_name, $gamemood_description);
    $prepare->execute();
    $prepare->close();

    redirect('gamemood_list.php');

    exit;
}

$gamemood_array = $gamemood_sql->fetch_all(MYSQLI_ASSOC);

$gamemood_name          = $gamemood_array[0]['gamemood_name'];
$gamemood_description   = $gamemood_array[0]['gamemood_description'];

$smarty->assign('gamemood_name', $gamemood_name);
$smarty->assign('gamemood_description', $gamemood_description);
$smarty->assign('tpl', 'gamemood_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');