<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

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

    exit;
}

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');