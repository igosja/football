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

$sql = "SELECT `injurytype_day`,
               `injurytype_name`
        FROM `injurytype`
        WHERE `injurytype_id`='$num_get'
        LIMIT 1";
$injurytype_sql = $mysqli->query($sql);

$count_injurytype = $injurytype_sql->num_rows;

if (0 == $count_injurytype)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['injurytype_name']))
{
    $injurytype_name = $_POST['injurytype_name'];
    $injurytype_day  = (int) $_POST['injurytype_day'];

    $sql = "UPDATE `injurytype` 
            SET `injurytype_name`=?,
                `injurytype_day`=?
            WHERE `injurytype_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $injurytype_name, $injurytype_day);
    $prepare->execute();
    $prepare->close();

    redirect('injurytype_list.php');
}

$injurytype_array = $injurytype_sql->fetch_all(1);

$tpl = 'injurytype_create';

include (__DIR__ . '/../view/admin_main.php');