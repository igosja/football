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

$sql = "SELECT `tournamenttype_name`,
               `tournamenttype_visitor`
        FROM `tournamenttype`
        WHERE `tournamenttype_id`='$num_get'
        LIMIT 1";
$tournamenttype_sql = $mysqli->query($sql);

$count_tournamenttype = $tournamenttype_sql->num_rows;

if (0 == $count_tournamenttype)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['tournamenttype_name']))
{
    $tournamenttype_name    = $_POST['tournamenttype_name'];
    $tournamenttype_visitor = (float) $_POST['tournamenttype_visitor'];

    $sql = "UPDATE `tournamenttype`
            SET `tournamenttype_name`=?,
                `tournamenttype_visitor`=?
            WHERE `tournamenttype_id`='$num_get'";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('sd', $tournamenttype_name, $tournamenttype_visitor);
    $prepare->execute();
    $prepare->close();

    redirect('tournamenttype_list.php');
}

$tournamenttype_array = $tournamenttype_sql->fetch_all(MYSQLI_ASSOC);

$tournamenttype_name    = $tournamenttype_array[0]['tournamenttype_name'];
$tournamenttype_visitor = $tournamenttype_array[0]['tournamenttype_visitor'];

$smarty->assign('tournamenttype_name', $tournamenttype_name);
$smarty->assign('tournamenttype_visitor', $tournamenttype_visitor);
$smarty->assign('tpl', 'tournamenttype_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');