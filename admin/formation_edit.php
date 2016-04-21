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

$sql = "SELECT `formation_name`, 
               `formation_position_id_1`,
               `formation_position_id_2`,
               `formation_position_id_3`,
               `formation_position_id_4`,
               `formation_position_id_5`,
               `formation_position_id_6`,
               `formation_position_id_7`,
               `formation_position_id_8`,
               `formation_position_id_9`,
               `formation_position_id_10`,
               `formation_position_id_11`
        FROM `formation`
        WHERE `formation_id`='$num_get'
        LIMIT 1";
$formation_sql = $mysqli->query($sql);

$count_formation = $formation_sql->num_rows;

if (0 == $count_formation)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['formation_name']))
{
    $formation_name  = $_POST['formation_name'];
    $position_number = array();

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

    $sql = "UPDATE `formation` 
            SET `formation_name` = ?,
                `formation_position_id_1` = ?,
                `formation_position_id_2` = ?,
                `formation_position_id_3` = ?,
                `formation_position_id_4` = ?,
                `formation_position_id_5` = ?,
                `formation_position_id_6` = ?,
                `formation_position_id_7` = ?,
                `formation_position_id_8` = ?,
                `formation_position_id_9` = ?,
                `formation_position_id_10` = ?,
                `formation_position_id_11` = ?
            WHERE `formation_id`='$num_get'";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param
                (
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

$formation_array = $formation_sql->fetch_all(MYSQLI_ASSOC);

$formation_name = $formation_array[0]['formation_name'];

$formation_position = array(
                            $formation_array[0]['formation_position_id_1'],
                            $formation_array[0]['formation_position_id_2'],
                            $formation_array[0]['formation_position_id_3'],
                            $formation_array[0]['formation_position_id_4'],
                            $formation_array[0]['formation_position_id_5'],
                            $formation_array[0]['formation_position_id_6'],
                            $formation_array[0]['formation_position_id_7'],
                            $formation_array[0]['formation_position_id_8'],
                            $formation_array[0]['formation_position_id_9'],
                            $formation_array[0]['formation_position_id_10'],
                            $formation_array[0]['formation_position_id_11']
                           );

$sql = "SELECT `position_id`, `position_name`
        FROM `position`
        ORDER BY `position_id` ASC";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('formation_position', $formation_position);
$smarty->assign('position_array', $position_array);
$smarty->assign('formation_name', $formation_name);
$smarty->assign('tpl', 'formation_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');