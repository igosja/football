<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

phpinfo();

print '<br/>Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br/>Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';