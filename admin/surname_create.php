<?php

include (__DIR__ . '/../include/include.php');

if (isset($_POST['surname_name']))
{
    $country_id     = (int) $_POST['country_id'];
    $surname_name   = $_POST['surname_name'];
    $surname_array  = explode(',', $surname_name);

    foreach ($surname_array as $surname_name)
    {
        $sql = "SELECT `surname_id`
                FROM `surname`
                WHERE `surname_name`=?
                LIMIT 1";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $surname_name);
        $prepare->execute();

        $surname_sql    = $prepare->get_result();
        $count_surname  = $surname_sql->num_rows;

        $prepare->close();

        if (0 == $count_surname)
        {
            $sql = "INSERT INTO `surname`
                    SET `surname_name`=?";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $surname_name);
            $prepare->execute();
            $prepare->close();

            $surname_id = $mysqli->insert_id;
        }
        else
        {
            $surname_array = $surname_sql->fetch_all(1);

            $surname_id = $surname_array[0]['surname_id'];
        }

        $sql = "SELECT `countrysurname_id`
                FROM `countrysurname`
                WHERE `countrysurname_surname_id`='$surname_id'
                AND `countrysurname_country_id`='$country_id'
                LIMIT 1";
        $check_sql = $mysqli->query($sql);

        $count_check = $check_sql->num_rows;

        if (0 == $count_check)
        {
            $sql = "INSERT INTO `countrysurname`
                    SET `countrysurname_surname_id`='$surname_id',
                        `countrysurname_country_id`='$country_id'";
            $mysqli->query($sql);
        }
    }

    redirect('surname_list.php');
}

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');