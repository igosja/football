    </div>
    <?php if (!isset($authorization_vip) || !$authorization_vip) { ?>
        <div class="page-content">
            <table class="block-table w100">
                <tr>
                    <td class="block-page center">
                        <p class="left header">Реклама <span class="grey"><a href="shop.php">[Отключить]</a></span></p>
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
    <?php }?>
    <div class="siteinfo">
        <div class="wrap">
            <a href="javascript:;" class="siteinfo-btn"></a>
            <h1 class="center">Футбольный онлайн менеджер для истинных любителей спорта №1!</h1>
            <p class="justify">Наверняка каждый из нас мечтал почувствовать себя тренером или менеджером настоящего футбольного клуба. Увлекательный поиск талантливых игроков, постепенное развитие инфраструктуры, выбор подходящей тактики на игру, регулярные матчи и, конечно же, победы, титулы и новые достижения! Именно это ждёт Вас в нашем мире виртуального футбола. Окунитесь в него и создайте клуб своей мечты!</p>
            <h2 class="center">Играть в наш футбольный онлайн менеджер может каждый!</h2>
            <p class="justify">Наш проект открыт для всех! Чтобы начать играть, Вам достаточно просто пройти элементарную процедуру регистрации либо зайти под своим профилем в социальных сетях. <strong>“Виртуальная Футбольная Лига”</strong> – это функциональный футбольный онлайн менеджер, в котором Вы получите возможность пройти увлекательный путь развития своей команды от низших дивизионов до побед в национальных чемпионатах и европейских кубках!</p>
            <h2 class="center">Скачивать ничего не надо!</h2>
            <p class="justify">Обращаем внимание, что наш футбольный онлайн менеджер является браузерной игрой. Поэтому Вам не надо будет скачивать какие-либо клиентские программы, тратить время на их утомительную установку и последующую настройку. Для игры Вам необходим только доступ к интернету и несколько минут свободного времени. При этом участие в турнирах является <strong>абсолютно бесплатным</strong>.</p>
            <h2 class="center">Вы обязательно станете чемпионом!</h2>
            <p class="justify">Хотим подчеркнуть, что для достижения успеха Вам не надо целыми сутками сидеть за компьютером. Чтобы поступательно развивать свой клуб, участвовать в трансферах и играть календарные матчи, Вам Вам достаточно иметь возможность хотя бы несколько раз в неделю посещать наш сайт." и на этом конец предложения!</p>
            <h2 class="center">Увлекательные футбольные матчи и первые победы уже ждут Вас!</h2>
            <p class="justify">Футбольный онлайн менеджер <strong>“Виртуальная Футбольная Лига”</strong> – это больше, чем обычная игра. Это сообщество людей, которые объединены страстью и любовью к футболу. Здесь Вы обязательно сможете найти интересных людей, заведете новые знакомства и просто отлично проведетё время в непринужденной и максимально комфортной атмосфере. Вперёд, пришло время занять тренерское кресло и кабинет менеджера!</p>
        </div>
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