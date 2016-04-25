    </div>
    <div class="footer">
        <p>Связь с администраницей: info@virtual-football-league.ru - <p>
        <?php if (1 < $authorization_permission && 1 == 0) { ?>
        <p>Страница сгенерирована за <?= round(microtime(true) - $start_time, 5); ?> сек.<p>
        <p>Потребление памяти: <?= number_format(memory_get_usage(), 0, ",", " "); ?> Б</p>
        <p>Версия сайта: <?= $site_array[0]['site_version_1'] ?>.<?= $site_array[0]['site_version_2'] ?>.<?= $site_array[0]['site_version_3'] ?>.<?= $site_array[0]['site_version_4'] ?> от <?= date('d.m.Y', $site_array[0]['site_version_date']); ?></p>
        <?php } ?>
        <?php if (1 < $authorization_permission && 1 == 0) { ?>
            <p><a href="admin">Административный раздел</a></p>
        <?php } ?>
    </div>

    <script src="/js/jquery.js"></script>
    <script src="/js/function.js"></script>
    <script src="/js/autocomplete.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/highcharts.js"></script>

</body>

</html>