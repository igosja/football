<?php

    include ($_SERVER['DOCUMENT_ROOT'] . '/Smarty/libs/Smarty.class.php');

    $smarty = new Smarty;

    $smarty->setTemplateDir($_SERVER['DOCUMENT_ROOT'] . '/smarty-templates');
    $smarty->setCompileDir($_SERVER['DOCUMENT_ROOT'] . '/smarty-templates_c');
    $smarty->setConfigDir($_SERVER['DOCUMENT_ROOT'] . '/smarty-configs');
    $smarty->setCacheDir($_SERVER['DOCUMENT_ROOT'] . '/smarty-cache');