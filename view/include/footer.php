    </div>
    <div class="page-content">
        <table class="block-table w100">
            <tr>
                <td class="block-page center">
                    <p class="left header">Реклама</p>
                    <script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins
                        class="adsbygoogle"
                        style="display:inline-block;width:300px;height:250px"
                        data-ad-client="ca-pub-9189986235139627"
                        data-ad-slot="9164813595"
                    ></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins
                        class="adsbygoogle"
                        style="display:inline-block;width:300px;height:250px"
                        data-ad-client="ca-pub-9189986235139627"
                        data-ad-slot="3118279999"
                    ></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                    <script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins
                        class="adsbygoogle"
                        style="display:inline-block;width:300px;height:250px"
                        data-ad-client="ca-pub-9189986235139627"
                        data-ad-slot="6071746393"
                    ></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </td>
            </tr>
        </table>
    </div>
    <div class="footer">
        <p>Связь с администраницей: info@virtual-football-league.ru<p>
        <p>Страница сгенерирована за <?= round(microtime(true) - $start_time, 5); ?> сек.<p>
        <p>Версия сайта: <?= $site_array[0]['site_version_1'] ?>.<?= $site_array[0]['site_version_2'] ?>.<?= $site_array[0]['site_version_3'] ?>.<?= $site_array[0]['site_version_4'] ?> от <?= date('d.m.Y', $site_array[0]['site_version_date']); ?></p>
        <?php if (1 < $authorization_permission) { ?>
            <p><a href="/admin">Административный раздел</a></p>
        <?php } ?>
    </div>
    <script src="/js/jquery.js"></script>
    <script src="/js/function.js?<?= $css_js_version; ?>"></script>
    <script src="/js/autocomplete.js"></script>
    <script src="/js/main.js?<?= $css_js_version; ?>"></script>
    <script src="/js/highcharts.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</body>
</html>