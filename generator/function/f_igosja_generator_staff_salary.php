<?php

function f_igosja_generator_staff_salary()
//Зарплата персонала
{
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
            WHERE `staff_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}