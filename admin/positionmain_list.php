<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['position_id']))
{
    $sql = "TRUNCATE `positionmain`";
    $mysqli->query($sql);

    foreach($_POST['position_id'] as $key=>$value)
    {
        $position_id = (int) $value;

        $sql = "INSERT INTO `positionmain`
                SET `positionmain_position_id`='$position_id'";
        $mysqli->query($sql);
    }

    redirect('positionmain_list.php');

    exit;
}

$sql = "SELECT `position_id`, `position_description`, `positionmain_id`
        FROM `position`
        LEFT JOIN `positionmain`
        ON `position_id`=`positionmain_position_id`
        ORDER BY `position_id`";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('position_array', $position_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');