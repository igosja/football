{capture name=tpl}
<!DOCTYPE html>
<html>

<head>
    <title>Административный раздел</title>
    <meta name="description" content="Футбольный онлайн менеджер" />
    <meta name="keywords" content="футбол, игра, менеджер, онлайн" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/css/admin.css">
</head>

<body>
    <noscript>
        <p class="center warning">
            В вашем браузере отключен javasript. Для корректной работы сайт рекомендуем включить javasript.
        </p>
    </noscript>
    {if isset($success_message)}
        <p class="alert center success">{$success_message}</p>
    {/if}
    {if isset($error_message)}
        <p class="alert center error">{$error_message}</p>
    {/if}
    {if isset($warning_message)}
        <p class="alert center warning">{$warning_message}</p>
    {/if}
    {if isset($info_message)}
        <p class="alert center info">{$info_message}</p>
    {/if}
<div class="content-back">
    <div class="content">
        {include file="admin/$tpl.html"}
    </div>
</div>
<div class="footer-back">
    <div class="footer">
        <!--<a href="https://passport.webmoney.ru/asp/certview.asp?wmid=274662367507" target="_blank">
        <img alt="" src="/img/webmoney.png">
        </a>-->
        <!--<a href="//www.liveinternet.ru/click" target="_blank"><img src="//counter.yadro.ru/logo?14.1" border="0" width="88" height="31" alt="" title="LiveInternet: показано число просмотров за 24 часа, посетителей за 24 часа и за сегодня"/></a>-->
        <p>Страница сгенерирована за {(microtime(true) - $start_time)|round:"5"} сек.<p>
        <p>Потребление памяти: {number_format(memory_get_usage(), 0, ",", " ")} Б</p>
        {if ($chapter == admin)}
            <p><a href="/">На сайт</a></p>
        {else}
            {if (1 < $authorization_permission)}
                <p><a href="admin">Административный раздел</a></p>
            {/if}
        {/if}
    </div>
</div>

<script src="/js/jquery.js"></script>
<script src="/js/function.js"></script>
<script src="/js/admin.js"></script>

</body>

</html>
{/capture}

{$smarty.capture.tpl|strip}

{*debug*}