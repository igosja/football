<?php

include('include/include.php');

if (isset($_POST['firstname'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = (int)$_POST['gender'];
    $day = (int)$_POST['birth']['day'];
    $month = (int)$_POST['birth']['month'];
    $year = (int)$_POST['birth']['year'];
    $country_id = (int)$_POST['country'];

    $sql = "UPDATE `user`
            SET `user_firstname`=?,
                `user_lastname`=?,
                `user_gender`=?,
                `user_birth_day`=?,
                `user_birth_month`=?,
                `user_birth_year`=?,
                `user_country_id`=?
            WHERE `user_id`='$authorization_id'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ssiiiii', $firstname, $lastname, $gender, $day, $month, $year, $country_id);
    $prepare->execute();
    $prepare->close();

    if (!empty($_POST['password'])) {
        $password = f_igosja_chiper_password($_POST['password']);

        $sql = "UPDATE `user`
                SET `user_password`='$password'
                WHERE `user_id`='$authorization_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $smarty->assign('success_message', 'Данные успешно сохранены');
}

$sql = "SELECT `user_birth_day`,
               `user_birth_month`,
               `user_birth_year`,
               `user_country_id`,
               `user_firstname`,
               `user_gender`,
               `user_lastname`
        FROM `user`
        WHERE `user_id`='$authorization_id'
        LIMIT 1";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_id`!='0'
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('user_array', $user_array);
$smarty->assign('country_array', $country_array);

$smarty->display('main-1.html');