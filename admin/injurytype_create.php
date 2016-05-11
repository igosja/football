<?php

include (__DIR__ . '/../include/include.php');

if (isset($_POST['injurytype_name']))
{
    $injurytype_name = $_POST['injurytype_name'];
    $injurytype_day  = (int) $_POST['injurytype_day'];

    $sql = "INSERT INTO `injurytype`
            SET `injurytype_name`=?,
                `injurytype_day`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('si', $injurytype_name, $injurytype_day);
    $prepare->execute();
    $prepare->close();

    redirect('injurytype_list.php');
}

include (__DIR__ . '/../view/admin_main.php');