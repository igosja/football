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

$sql = "SELECT `gender_name`
        FROM `gender`
        WHERE `gender_id`='$num_get'
        LIMIT 1";
$gender_sql = $mysqli->query($sql);

$count_gender = $gender_sql->num_rows;

if (0 == $count_gender)
{
    include (__DIR__ . '/../view/wrong_page.php');
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

$gender_array = $gender_sql->fetch_all(1);

$tpl = 'gender_create';

include (__DIR__ . '/../view/admin_main.php');