<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['formation_name']))
{
    $formation_name = $_POST['formation_name'];

    foreach ($_POST['position_number'] as $key=>$value)
    {
        if ('' != $value)
        {
            $position_number[] = (int) $value;
        }
    }

    foreach ($_POST['position_id'] as $key=>$value)
    {
        for ($i=0; $i<$position_number[$key]; $i++)
        {
            $position_array[] = (int) $value;
        }
    }

    $sql = "INSERT INTO `formation`
            SET `formation_name`=?,
                `formation_position_id_1`=?,
                `formation_position_id_2`=?,
                `formation_position_id_3`=?,
                `formation_position_id_4`=?,
                `formation_position_id_5`=?,
                `formation_position_id_6`=?,
                `formation_position_id_7`=?,
                `formation_position_id_8`=?,
                `formation_position_id_9`=?,
                `formation_position_id_10`=?,
                `formation_position_id_11`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param(
                            'ssssssssssss', 
                            $formation_name, 
                            $position_array[0],
                            $position_array[1],
                            $position_array[2],
                            $position_array[3],
                            $position_array[4],
                            $position_array[5],
                            $position_array[6],
                            $position_array[7],
                            $position_array[8],
                            $position_array[9],
                            $position_array[10]
                        );
    $prepare->execute();
    $prepare->close();

    redirect('formation_list.php');
}

$sql = "SELECT `position_id`, `position_name`
        FROM `position`
        ORDER BY `position_id` ASC";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('position_array', $position_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');