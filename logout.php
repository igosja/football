<?php

include($_SERVER['DOCUMENT_ROOT'] . 'include/include.php');

session_destroy();

redirect('index.php');