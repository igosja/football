<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `city_country_id`,
               `team_name`
        FROM `team`
        LEFT JOIN `city`
        ON `city_id`=`team_city_id`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name  = $team_array[0]['team_name'];
$country_id = $team_array[0]['city_country_id'];

if (isset($_GET['staff_id'])
    && isset($_GET['ok']))
{
    $staff_id   = (int) $_GET['staff_id'];
    $ok         = (int) $_GET['ok'];

    $sql = "SELECT `name_name`,
                   `staff_staffpost_id`,
                   `staffpost_name`,
                   `surname_name`
            FROM `staff`
            LEFT JOIN `staffpost`
            ON `staffpost_id`=`staff_staffpost_id`
            LEFT JOIN `name`
            ON `staff_name_id`=`name_id`
            LEFT JOIN `surname`
            ON `staff_surname_id`=`surname_id`
            WHERE `staff_team_id`='0'
            AND `staff_id`='$staff_id'
            LIMIT 1";
    $staff_sql = $mysqli->query($sql);

    $count_staff = $staff_sql->num_rows;

    if (0 == $count_staff)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Персонал выбран неправильно.';

        redirect('team_team_transfer_search_staff.php?num=' . $num_get);
    }

    $staff_array = $staff_sql->fetch_all(MYSQLI_ASSOC);

    $name       = $staff_array[0]['name_name'];
    $surname    = $staff_array[0]['surname_name'];
    $post       = $staff_array[0]['staffpost_name'];
    $post_id    = $staff_array[0]['staff_staffpost_id'];

    if (1 == $ok)
    {
        $sql = "UPDATE `staff`
                SET `staff_team_id`='0'
                WHERE `staff_team_id`='$num_get'
                AND `staff_staffpost_id`='$post_id'";
        $mysqli->query($sql);

        $sql = "UPDATE `staff`
                SET `staff_team_id`='$num_get'
                WHERE `staff_id`='$staff_id'
                LIMIT 1";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Изменения успешно сохранены.';

        redirect('team_team_staff_staff.php?num=' . $num_get);
    }
}

$sql = "SELECT `staffpost_id`
        FROM `staffpost`
        ORDER BY `staffpost_id` ASC";
$staffpost_sql = $mysqli->query($sql);

$count_staffpost = $staffpost_sql->num_rows;
$staffpost_array = $staffpost_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_staffpost; $i++)
{
    $staffpost_id = $staffpost_array[$i]['staffpost_id'];

    for ($j=0; $j<10; $j++)
    {
        $min_reputation = $j * 10;
        $max_reputation = ($j + 1) * 10;

        $sql = "SELECT COUNT(`staff_id`) AS `count`
                FROM `staff`
                WHERE `staff_staffpost_id`='$staffpost_id'
                AND `staff_country_id`='$country_id'
                AND `staff_team_id`='0'
                AND `staff_reputation` BETWEEN '$min_reputation' AND '$max_reputation'";
        $staff_sql = $mysqli->query($sql);

        $staff_array = $staff_sql->fetch_all(MYSQLI_ASSOC);

        $count = $staff_array[0]['count'];

        if (0 == $count)
        {
            $age        = rand (30, 50);
            $reputation = rand($min_reputation, $max_reputation);

            $sql = "SELECT `countryname_name_id`, `countrysurname_surname_id`
                    FROM `countryname`
                    LEFT JOIN
                    (
                        SELECT `countrysurname_surname_id`, `countrysurname_country_id`
                        FROM `countrysurname`
                        WHERE `countrysurname_country_id`='$country_id'
                        ORDER BY RAND()
                        LIMIT 1
                    ) AS `t2`
                    ON `countrysurname_country_id`=`countryname_country_id`
                    WHERE `countryname_country_id`='$country_id'
                    ORDER BY RAND()
                    LIMIT 1";
            $name_sql = $mysqli->query($sql);

            $name_array = $name_sql->fetch_all(MYSQLI_ASSOC);

            $name_id    = $name_array[0]['countryname_name_id'];
            $surname_id = $name_array[0]['countrysurname_surname_id'];

            $sql = "INSERT INTO `staff`
                    SET `staff_team_id`='0',
                        `staff_staffpost_id`='$staffpost_id',
                        `staff_country_id`='$country_id',
                        `staff_name_id`='$name_id',
                        `staff_surname_id`='$surname_id',
                        `staff_reputation`='$reputation',
                        `staff_age`='$age'";
            $mysqli->query($sql);

            $last_staff_id = $mysqli->insert_id;

            $sql = "INSERT INTO `staffattribute` (`staffattribute_staff_id`, `staffattribute_attributestaff_id`, `staffattribute_value`)
                    SELECT '$last_staff_id', `attributestaff_id`, '$min_reputation'+RAND()*'10'
                    FROM `attributestaff`
                    ORDER BY `attributestaff_id` ASC";
            $mysqli->query($sql);
        }
    }
}

$sql = "UPDATE `staff`
        LEFT JOIN
        (
            SELECT `staffattribute_staff_id`,
                   SUM(`staffattribute_value`) AS `power`
            FROM `staffattribute`
            GROUP BY `staffattribute_staff_id`
        ) AS `t1`
        ON `staff_id`=`staffattribute_staff_id`
        SET `staff_salary`=ROUND(POW(`power`, 1.3)),
            `staff_reputation`=`power`/'" . MAX_STAFF_POWER . "'*'100'
        WHERE `staff_team_id`='0'
        AND `staff_id`!='0'";
$mysqli->query($sql);

if (isset($_GET['surname']) && !empty($_GET['surname']))
{
    $sql_surname = $_GET['surname'];
}
else
{
    $sql_surname = '';
}

if (isset($_GET['position']) && !empty($_GET['position']))
{
    $sql_position = (int) $_GET['position'];
}
else
{
    $sql_position = 0;
}

if (isset($_GET['country']) && !empty($_GET['country']))
{
    $sql_country = (int) $_GET['country'];
}
else
{
    $sql_country = 0;
}

if (0 == $sql_position)
{
    $sql_position = 1;
}
else
{
    $sql_position = "`staff_staffpost_id`='$sql_position'";
}

if (0 == $sql_country)
{
    $sql_country = 1;
}
else
{
    $sql_country = "`staff_country_id`='$sql_country'";
}

if (isset($_GET['page']))
{
    $page = (int) $_GET['page'];
}
else
{
    $page = 1;
}

$offset = ($page - 1) * 30;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `country_id`,
               `country_name`,
               `name_name`,
               `staff_id`,
               `staff_reputation`,
               `staff_salary`,
               `staffpost_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `staff`
        LEFT JOIN `name`
        ON `name_id`=`staff_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`staff_surname_id`
        LEFT JOIN `team`
        ON `team_id`=`staff_team_id`
        LEFT JOIN `country`
        ON `country_id`=`staff_country_id`
        LEFT JOIN `staffpost`
        ON `staffpost_id`=`staff_staffpost_id`
        WHERE `staff_team_id`='0'
        AND $sql_country
        AND $sql_position
        AND `surname_name` LIKE ?
        ORDER BY `staff_reputation` DESC, `staff_id` ASC
        LIMIT $offset, 30";
$like    = '%' . $sql_surname . '%';
$prepare = $mysqli->prepare($sql);
$prepare->bind_param('s', $like);
$prepare->execute();
$staff_sql = $prepare->get_result();
$prepare->close();

$staff_array = $staff_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count`";
$count_page = $mysqli->query($sql);
$count_page = $count_page->fetch_all(MYSQLI_ASSOC);
$count_page = $count_page[0]['count'];
$count_page = ceil($count_page / 30);

$sql = "SELECT `staffpost_id`,
               `staffpost_name`
        FROM `staffpost`
        ORDER BY `staffpost_id` ASC";
$staffpost_sql = $mysqli->query($sql);

$staffpost_array = $staffpost_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_season_id`!='0'
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$num                = $num_get;
$header_title       = $team_name;
$seo_title          = $header_title . '. Поиск персонала. ' . $seo_title;
$seo_description    = $header_title . '. Поиск персонала. ' . $seo_description;
$seo_keywords       = $header_title . ', поиск персонала, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');