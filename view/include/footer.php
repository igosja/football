    </div>
    <div class="footer">
        <!--<a href="https://passport.webmoney.ru/asp/certview.asp?wmid=274662367507" target="_blank">
        <img alt="" src="/img/webmoney.png">
        </a>-->
        <!--<a href="//www.liveinternet.ru/click" target="_blank"><img src="//counter.yadro.ru/logo?14.1" border="0" width="88" height="31" alt="" title="LiveInternet: показано число просмотров за 24 часа, посетителей за 24 часа и за сегодня"/></a>-->
        <p>Страница сгенерирована за <?php print round(microtime(true) - $start_time, 5); ?> сек.<p>
        <p>Потребление памяти: <?php print number_format(memory_get_usage(), 0, ",", " "); ?> Б</p>
        <?php if (1 < $authorization_permission) { ?>
            <p><a href="admin">Административный раздел</a></p>
        <?php } ?>
    </div>

    <script src="/js/jquery.js"></script>
    <script src="/js/function.js"></script>
    <script src="/js/autocomplete.js"></script>
    <script src="/js/main.js"></script>

</body>

</html>