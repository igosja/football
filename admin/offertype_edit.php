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

$sql = "SELECT `offertype_name`
        FROM `offertype`
        WHERE `offertype_id`='$get_num'
        LIMIT 1";
$offertype_sql = $mysqli->query($sql);

$count_offertype = $offertype_sql->num_rows;

if (0 == $count_offertype)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['offertype_name']))
{
    $offertype_name = $_POST['offertype_name'];

    $sql = "UPDATE `offertype` 
            SET `offertype_name`=?
            WHERE `offertype_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $offertype_name);
    $prepare->execute();
    $prepare->close();

    redirect('offertype_list.php');

    exit;
}

$offertype_array = $offertype_sql->fetch_all(MYSQLI_ASSOC);

$offertype_name = $offertype_array[0]['offertype_name'];

$smarty->assign('offertype_name', $offertype_name);
$smarty->assign('tpl', 'offertype_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');