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

$sql = "SELECT `gender_name`
        FROM `gender`
        WHERE `gender_id`='$num_get'
        LIMIT 1";
$gender_sql = $mysqli->query($sql);

$count_gender = $gender_sql->num_rows;

if (0 == $count_gender)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

if (isset($_POST['gender_name']))
{
    $gender_name = $_POST['gender_name'];

    $sql = "UPDATE `gender` 
            SET `gender_name`=?
            WHERE `gender_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $gender_name);
    $prepare->execute();
    $prepare->close();

    redirect('gender_list.php');
}

$gender_array = $gender_sql->fetch_all(MYSQLI_ASSOC);

$gender_name = $gender_array[0]['gender_name'];

$smarty->assign('gender_name', $gender_name);
$smarty->assign('tpl', 'gender_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');