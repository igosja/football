<?php

include (__DIR__ . '/include/include.php');

session_destroy();

redirect('index.php');