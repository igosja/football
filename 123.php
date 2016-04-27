<?php

include (__DIR__ . '/include/include.php');

$xml    = 'PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48cmVzcG9uc2U PHZlcnNpb24 MS4zPC92ZXJzaW9uPjx0eXBlPnJlc3VsdDwvdHlwZT48bWVyY2hhbnRfaWQ NTcwNjU8L21lcmNoYW50X2lkPjxsYW5ndWFnZT5ydTwvbGFuZ3VhZ2U PG9yZGVyX2lkPklEXzE8L29yZGVyX2lkPjxhbW91bnQ NTQuMDA8L2Ftb3VudD48Y3VycmVuY3k VVNEPC9jdXJyZW5jeT48ZGVzY3JpcHRpb24 0J/QvtC/0L7Qu9C90LXQvdC40LUg0YHRh9C10YLQsCDQvdCwINGB0LDQudGC0LUg0JLQuNGA0YLRg9Cw0LvRjNC90L7QuSDRhNGD0YLQsdC 0LvRjNC90L7QuSDQu9C40LPQuDwvZGVzY3JpcHRpb24 PHBheW1vZGU cHNjYl90ZXJtaW5hbDwvcGF5bW9kZT48dHJhbnNfaWQ MTYyNDM5MjwvdHJhbnNfaWQ PHN0YXR1cz5zdWNjZXNzPC9zdGF0dXM PGVycm9yX21zZz48L2Vycm9yX21zZz48dGVzdF9tb2RlPjE8L3Rlc3RfbW9kZT48b3RoZXI PCFbQ0RBVEFbXV0 PC9vdGhlcj48L3Jlc3BvbnNlPg==';
$sign   = 'ODQzMjc2YjNlZGM0ZmY1Y2ZiOTM5YjYyNmEwNzk2YjE=';

$secret_key = 'hRCuJWDxBpG5eNj';
$hidden_key = '9cCCtEqwPcgzZKf';
$api_key    = '2rC7Xb3lbg2OAwr';
$xml        = str_replace(' ', '+', $xml);
$sign       = str_replace(' ', '+', $sign);
$xml        = base64_decode($xml);
$sign_check = base64_encode(md5($hidden_key . $xml . $hidden_key));

$xml = simplexml_load_string($xml);

print $xml->status;
print $xml->order_id;

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';