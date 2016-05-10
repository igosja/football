<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `gamestyle_description`, `gamestyle_name`
        FROM `gamestyle`
        WHERE `gamestyle_id`='$num_get'
        LIMIT 1";
$gamestyle_sql = $mysqli->query($sql);

$count_gamestyle = $gamestyle_sql->num_rows;

if (0 == $count_gamestyle)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');

    exit;
}

if (isset($_POST['gamestyle_name']))
{
    $gamestyle_name          = $_POST['gamestyle_name'];
    $gamestyle_description   = $_POST['gamestyle_description'];

    $sql = "UPDATE `gamestyle` 
            SET `gamestyle_name`=?,
                `gamestyle_description`=?
            WHERE `gamestyle_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $gamestyle_name, $gamestyle_description);
    $prepare->execute();
    $prepare->close();

    redirect('gamestyle_list.php');
}

$gamestyle_array = $gamestyle_sql->fetch_all(MYSQLI_ASSOC);

$gamestyle_name          = $gamestyle_array[0]['gamestyle_name'];
$gamestyle_description   = $gamestyle_array[0]['gamestyle_description'];

$smarty->assign('gamestyle_name', $gamestyle_name);
$smarty->assign('gamestyle_description', $gamestyle_description);
$smarty->assign('tpl', 'gamestyle_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');