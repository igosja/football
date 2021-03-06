<?php

include (__DIR__ . '/../include/include.php');

if (isset($_POST['name_name']))
{
    $country_id = (int) $_POST['country_id'];
    $name_name  = $_POST['name_name'];
    $name_array = explode(',', $name_name);

    foreach ($name_array as $name_name)
    {
        $sql = "SELECT `name_id`
                FROM `name`
                WHERE `name_name`=?
                LIMIT 1";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $name_name);
        $prepare->execute();

        $name_sql    = $prepare->get_result();
        $count_name  = $name_sql->num_rows;

        $prepare->close();

        if (0 == $count_name)
        {
            $sql = "INSERT INTO `name`
                    SET `name_name`=?";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $name_name);
            $prepare->execute();
            $prepare->close();

            $name_id = $mysqli->insert_id;
        }
        else
        {
            $name_array = $name_sql->fetch_all(1);

            $name_id = $name_array[0]['name_id'];
        }

        $sql = "SELECT `countryname_id`
                FROM `countryname`
                WHERE `countryname_name_id`='$name_id'
                AND `countryname_country_id`='$country_id'
                LIMIT 1";
        $check_sql = $mysqli->query($sql);

        $count_check = $check_sql->num_rows;

        if (0 == $count_check)
        {
            $sql = "INSERT INTO `countryname`
                    SET `countryname_name_id`='$name_id',
                        `countryname_country_id`='$country_id'";
            $mysqli->query($sql);
        }
    }

    redirect('name_list.php');
}

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');