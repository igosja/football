<?php

include (__DIR__ . '/include/include.php');

$email      = 'igosja@ukr.net';
$username   = 'Игося';
$message    =
'Здравствуйте, ' . $username . '.
Мы заметили, что вы давно не заходили на сайт Виртуальной футбольной лиги (virtual-football-league.net).
На нашем сайте вы можете сделать карьеру успешного тренера-менеджера.
В роли тренера ваша задача - определять тактику, стратегию и схему игры команды, выбирать футболистов в стартовый состав. Следить за усталостью и формой футболистов, проводить тренировки. Участвовать в национальном чемпионате и кубке своей страны, претендовать на попадание в Лигу чемпионов.
В роли менеджера задачи ещё интереснее - построить инфраструктуру команды (стадион, тренировочную базу и спортивную школу), успешно работать на трансферном рынке, организовывать и принимать участие в товарищеских матчах.
Наслаждайтесь!
Команда Виртуальной футбольной лиги.';
$subject    = 'Виртуальная футбольная лига';
$from       = 'From: noreply@' . SITE_URL;
$mail       = mail($email, $subject, $message, $from);

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';