<?php

function f_igosja_generator_email()
//Отправка письма менеджерам, которые давно не заходили на сайт
{
    $sql = "SELECT `user_email`,
                   `user_login`,
                   `user_id`
            FROM `user`
            WHERE `user_last_visit`<UNIX_TIMESTAMP()-'1728000'
            AND `user_letter`='2'
            AND `user_email` IS NOT NULL
            AND `user_email`!=''
            AND `user_id`!='0'
            LIMIT 10";
    $user_sql = f_igosja_mysqli_query($sql);

    $count_user = $user_sql->num_rows;
    $user_array = $user_sql->fetch_all(1);

    for ($i=0; $i<$count_user; $i++)
    {
        $user_id    = $user_array[$i]['user_id'];
        $user_login = $user_array[$i]['user_login'];
        $user_email = $user_array[$i]['user_email'];

        $message    =
'Здравствуйте, ' . $user_login . '.

Мы заметили, что вы давно не заходили на сайт Виртуальной футбольной лиги (virtual-football-league.ru).
На нашем сайте вы можете сделать карьеру успешного тренера-менеджера.
В роли тренера ваша задача - определять тактику, стратегию и схему игры команды, выбирать футболистов в стартовый состав. Следить за усталостью и формой футболистов, проводить тренировки. Участвовать в национальном чемпионате и кубке своей страны, претендовать на попадание в Лигу чемпионов.
В роли менеджера задачи ещё интереснее - построить инфраструктуру команды (стадион, тренировочную базу и спортивную школу), успешно работать на трансферном рынке, организовывать и принимать участие в товарищеских матчах.

Наслаждайтесь!

Команда Виртуальной футбольной лиги.';
        $subject    = 'Виртуальная футбольная лига';
        $from       = 'From: noreply@virtual-football-league.ru';

        mail($user_email, $subject, $message, $from);

        $sql = "UPDATE `user`
                SET `user_letter`='3'
                WHERE `user_id`='$user_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }

    $sql = "SELECT `user_email`,
                   `user_login`,
                   `user_id`
            FROM `user`
            WHERE `user_last_visit`<UNIX_TIMESTAMP()-'864000'
            AND `user_letter`='1'
            AND `user_email` IS NOT NULL
            AND `user_email`!=''
            AND `user_id`!='0'
            LIMIT 10";
    $user_sql = f_igosja_mysqli_query($sql);

    $count_user = $user_sql->num_rows;
    $user_array = $user_sql->fetch_all(1);

    for ($i=0; $i<$count_user; $i++)
    {
        $user_id    = $user_array[$i]['user_id'];
        $user_login = $user_array[$i]['user_login'];
        $user_email = $user_array[$i]['user_email'];

        $message    =
'Здравствуйте, ' . $user_login . '.

Мы заметили, что вы давно не заходили на сайт Виртуальной футбольной лиги (virtual-football-league.ru).
На нашем сайте вы можете сделать карьеру успешного тренера-менеджера.
В роли тренера ваша задача - определять тактику, стратегию и схему игры команды, выбирать футболистов в стартовый состав. Следить за усталостью и формой футболистов, проводить тренировки. Участвовать в национальном чемпионате и кубке своей страны, претендовать на попадание в Лигу чемпионов.
В роли менеджера задачи ещё интереснее - построить инфраструктуру команды (стадион, тренировочную базу и спортивную школу), успешно работать на трансферном рынке, организовывать и принимать участие в товарищеских матчах.

Наслаждайтесь!

Команда Виртуальной футбольной лиги.';
        $subject    = 'Виртуальная футбольная лига';
        $from       = 'From: noreply@virtual-football-league.ru';

        mail($user_email, $subject, $message, $from);

        $sql = "UPDATE `user`
                SET `user_letter`='2'
                WHERE `user_id`='$user_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }

    $sql = "SELECT `user_email`,
                   `user_login`,
                   `user_id`
            FROM `user`
            WHERE `user_last_visit`<UNIX_TIMESTAMP()-'432000'
            AND `user_letter`='0'
            AND `user_email` IS NOT NULL
            AND `user_email`!=''
            AND `user_id`!='0'
            LIMIT 10";
    $user_sql = f_igosja_mysqli_query($sql);

    $count_user = $user_sql->num_rows;
    $user_array = $user_sql->fetch_all(1);

    for ($i=0; $i<$count_user; $i++)
    {
        $user_id    = $user_array[$i]['user_id'];
        $user_login = $user_array[$i]['user_login'];
        $user_email = $user_array[$i]['user_email'];

        $message    =
'Здравствуйте, ' . $user_login . '.

Мы заметили, что вы давно не заходили на сайт Виртуальной футбольной лиги (virtual-football-league.ru).
На нашем сайте вы можете сделать карьеру успешного тренера-менеджера.
В роли тренера ваша задача - определять тактику, стратегию и схему игры команды, выбирать футболистов в стартовый состав. Следить за усталостью и формой футболистов, проводить тренировки. Участвовать в национальном чемпионате и кубке своей страны, претендовать на попадание в Лигу чемпионов.
В роли менеджера задачи ещё интереснее - построить инфраструктуру команды (стадион, тренировочную базу и спортивную школу), успешно работать на трансферном рынке, организовывать и принимать участие в товарищеских матчах.

Наслаждайтесь!

Команда Виртуальной футбольной лиги.';
        $subject    = 'Виртуальная футбольная лига';
        $from       = 'From: noreply@virtual-football-league.ru';

        mail($user_email, $subject, $message, $from);

        $sql = "UPDATE `user`
                SET `user_letter`='1'
                WHERE `user_id`='$user_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }

    usleep(1);

    print '.';
    flush();
}