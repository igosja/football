<?php

include (__DIR__ . '/include/include.php');

$private_key    = 'xjaJgqw2L2zCMT1Bs7lVcM7xRXzAwayVO1h1nZbz';
$public_key     = 'i33620494410';

$data = 'eyJhY3Rpb24iOiJwYXkiLCJwYXltZW50X2lkIjoxNjMyODI5ODcsInN0YXR1cyI6InNhbmRib3giLCJ2ZXJzaW9uIjozLCJ0eXBlIjoiYnV5IiwicGF5dHlwZSI6InByaXZhdDI0IiwicHVibGljX2tleSI6ImkzMzYyMDQ5NDQxMCIsImFjcV9pZCI6NDE0OTYzLCJvcmRlcl9pZCI6ImlkXzEyMyIsImxpcXBheV9vcmRlcl9pZCI6IjVCNFFMUkhOMTQ2MTQ5ODY3NTA5OTMxMSIsImRlc2NyaXB0aW9uIjoi0J/QvtC/0L7Qu9C90LXQvdC40LUg0YHRh9C10YLQsCDQvdCwINGB0LDQudGC0LUg0JLQuNGA0YLRg9Cw0LvRjNC90L7QuSDRhNGD0YLQsdC+0LvRjNC90L7QuSDQu9C40LPQuCIsInNlbmRlcl9waG9uZSI6IjM4MDUwMTM3MTU2NyIsInNlbmRlcl9jYXJkX21hc2syIjoiNTIxMTUzKjUwIiwic2VuZGVyX2NhcmRfYmFuayI6InBiIiwic2VuZGVyX2NhcmRfY291bnRyeSI6ODA0LCJpcCI6IjE5My40My4yMTEuNzciLCJhbW91bnQiOjIuMCwiY3VycmVuY3kiOiJVU0QiLCJzZW5kZXJfY29tbWlzc2lvbiI6MC4wLCJyZWNlaXZlcl9jb21taXNzaW9uIjowLjA2LCJhZ2VudF9jb21taXNzaW9uIjowLjAsImFtb3VudF9kZWJpdCI6NTAuNzYsImFtb3VudF9jcmVkaXQiOjUwLjc2LCJjb21taXNzaW9uX2RlYml0IjowLjAsImNvbW1pc3Npb25fY3JlZGl0IjoxLjQsImN1cnJlbmN5X2RlYml0IjoiVUFIIiwiY3VycmVuY3lfY3JlZGl0IjoiVUFIIiwic2VuZGVyX2JvbnVzIjowLjAsImFtb3VudF9ib251cyI6MC4wLCJtcGlfZWNpIjoiNyIsImlzXzNkcyI6ZmFsc2UsInRyYW5zYWN0aW9uX2lkIjoxNjMyODI5ODd9';

$signature = 'YQrD/LXd2xInMD2m7JzxsWknEoA=';
$sign_check = base64_encode(sha1($private_key . $data . $private_key, 1));

print $signature == $sign_check;
print '<br/>';

$json = base64_decode($data);
$json = json_decode($json, true);

print $json['order_id'];

print '<pre>';
print_r($json);

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';