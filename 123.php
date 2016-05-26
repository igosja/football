<?php

include (__DIR__ . '/include/include.php');

$first  = 6;
$second = 11 + 15 + 22 + 24 + 10 + 20;

if (0 == $first)
{
    $first = 0;
}
elseif (0 == $first % 3)
{
    $first = 1;
}
elseif (1 == $first % 3)
{
    $first = 2;
}
else
{
    $first = 3;
}

if (0 == $second)
{
    $second = 0;
}
elseif (0 == $second % 3)
{
    $second = 1;
}
elseif (1 == $second % 3)
{
    $second = 2;
}
else
{
    $second = 3;
}

print $first;
print '<br/>';
print $second;

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';