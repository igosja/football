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

$sql = "SELECT `tournamenttype_name`
        FROM `tournamenttype`
        WHERE `tournamenttype_id`='$get_num'
        LIMIT 1";
$tournamenttype_sql = $mysqli->query($sql);

$count_tournamenttype = $tournamenttype_sql->num_rows;

if (0 == $count_tournamenttype)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['tournamenttype_name']))
{
    $tournamenttype_name = $_POST['tournamenttype_name'];

    $sql = "UPDATE `tournamenttype`
            SET `tournamenttype_name`=?
            WHERE `tournamenttype_id`='$get_num'";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $tournamenttype_name);
    $prepare->execute();
    $prepare->close();

    redirect('tournamenttype_list.php');

    exit;
}

$tournamenttype_array = $tournamenttype_sql->fetch_all(MYSQLI_ASSOC);

$tournamenttype_name = $tournamenttype_array[0]['tournamenttype_name'];

$smarty->assign('tournamenttype_name', $tournamenttype_name);
$smarty->assign('tpl', 'tournamenttype_create');

$smarty->display('admin_main.html');