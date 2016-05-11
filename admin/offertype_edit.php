<?php

include (__DIR__ . '/../include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `offertype_name`
        FROM `offertype`
        WHERE `offertype_id`='$num_get'
        LIMIT 1";
$offertype_sql = $mysqli->query($sql);

$count_offertype = $offertype_sql->num_rows;

if (0 == $count_offertype)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['offertype_name']))
{
    $offertype_name = $_POST['offertype_name'];

    $sql = "UPDATE `offertype` 
            SET `offertype_name`=?
            WHERE `offertype_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $offertype_name);
    $prepare->execute();
    $prepare->close();

    redirect('offertype_list.php');
}

$offertype_array = $offertype_sql->fetch_all(MYSQLI_ASSOC);

$tpl = 'offertype_create';

include (__DIR__ . '/../view/admin_main.php');