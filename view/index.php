<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="center header">Футбольный онлайн менеджер для истинных любителей спорта №1!</p>
            <p class="justify">Наверняка каждый из нас мечтал почувствовать себя тренером или менеджером настоящего футбольного клуба. Увлекательный поиск талантливых игроков, постепенное развитие инфраструктуры, выбор подходящей тактики на игру, регулярные матчи и, конечно же, победы, титулы и новые достижения! Именно это ждёт Вас в нашем мире виртуального футбола. Окунитесь в него и создайте клуб своей мечты!</p>
            <p class="center header">Играть в наш футбольный онлайн менеджер может каждый!</p>
            <p class="justify">Наш проект открыт для всех! Чтобы начать играть, Вам достаточно просто пройти элементарную процедуру регистрации либо зайти под своим профилем в социальных сетях. <strong>“Виртуальная Футбольная Лига”</strong> – это функциональный футбольный онлайн менеджер, в котором Вы получите возможность пройти увлекательный путь развития своей команды от низших дивизионов до побед в национальных чемпионатах и европейских кубках!</p>
            <br />
            <p class="center"><a href="registration.php" class="button-link"><button>Зарегистрироваться</button></a></p>
            <p class="center">или войти через</p>
            <p class="center social-block">
                <?php foreach ($social_array as $item) { ?>
                    <a href="<?= $item['url']; ?>">
                        <img
                            alt="<?= $item['alt']; ?>"
                            class="img-30"
                            src="/img/social/<?= $item['img']; ?>.png"
                        />
                    </a>
                <?php } ?>
            </p>
            <p class="center header">Скачивать ничего не надо!</p>
            <p class="justify">Обращаем внимание, что наш футбольный онлайн менеджер является браузерной игрой. Поэтому Вам не надо будет скачивать какие-либо клиентские программы, тратить время на их утомительную установку и последующую настройку. Для игры Вам необходим только доступ к интернету и несколько минут свободного времени. При этом участие в турнирах является <strong>абсолютно бесплатным</strong>.</p>
            <p class="center header">Вы обязательно станете чемпионом!</p>
            <p class="justify">Хотим подчеркнуть, что для достижения успеха Вам не надо целыми сутками сидеть за компьютером. Чтобы поступательно развивать свой клуб, участвовать в трансферах и играть календарные матчи, Вам Вам достаточно иметь возможность хотя бы несколько раз в неделю посещать наш сайт." и на этом конец предложения!</p>
            <p class="center header">Увлекательные футбольные матчи и первые победы уже ждут Вас!</p>
            <p class="justify">Футбольный онлайн менеджер <strong>“Виртуальная Футбольная Лига”</strong> – это больше, чем обычная игра. Это сообщество людей, которые объединены страстью и любовью к футболу. Здесь Вы обязательно сможете найти интересных людей, заведете новые знакомства и просто отлично проведетё время в непринужденной и максимально комфортной атмосфере. Вперёд, пришло время занять тренерское кресло и кабинет менеджера!</p>
        </td>
        <td class="block-page w1" rowspan="2">
            <p class="header">Кнопки</p>
            <a href="//www.liveinternet.ru/click" target="_blank">
                <img
                    alt="LiveInternet"
                    border="0"
                    height="120"
                    src="//counter.yadro.ru/logo?27.1"
                    title="LiveInternet: показано количество просмотров и посетителей"
                    width="88"
                />
            </a>
            <br />
            <br />
<!--            <a href="http://www.pay2pay.com/" target="_blank">-->
<!--                <img src="/img/pay2pay.png" width="88" />-->
<!--            </a>-->
<!--            <br />-->
<!--            <br />-->
            <a href="//www.free-kassa.ru/"><img src="//www.free-kassa.ru/img/fk_btn/18.png"></a>
            <br />
            <br />
            <a href="https://passport.webmoney.ru/asp/certview.asp?wmid=274662367507" target="_blank">
                <img src="/img/webmoney.png" />
            </a>
        </td>
    </tr>
    <tr>
        <td class="block-page">
            <p class="header">Ближайшее расписание</p>
            <table class="striped w100">
                <tr>
                    <th>Дата</th>
                    <th>Турнир</th>
                </tr>
                <?php foreach ($shedule_array as $item) { ?>
                    <?php

                    if (TOURNAMENT_TYPE_CHAMPIONSHIP == $item['tournamenttype_id'])
                    {
                        $link = 'continent_tournament_championship.php?num=1';
                    }
                    elseif (TOURNAMENT_TYPE_CUP == $item['tournamenttype_id'])
                    {
                        $link = 'continent_tournament_cup.php?num=1';
                    }
                    elseif (TOURNAMENT_TYPE_CHAMPIONS_LEAGUE == $item['tournamenttype_id'])
                    {
                        $link = 'league_review_profile.php?num=3';
                    }
                    elseif (TOURNAMENT_TYPE_WORLD_CUP == $item['tournamenttype_id'])
                    {
                        $link = 'worldcup_review_profile.php?num=2';
                    }
                    else
                    {
                        $link = 'javascript:;';
                    }

                    ?>
                    <tr <?php if ($item['shedule_date'] == date('Y-m-d')) { ?>class="current"<?php } ?>>
                        <td class="center w15">12:00 МСК, <?= f_igosja_ufu_date($item['shedule_date']); ?></td>
                        <td>
                            <a href="<?= $link; ?>">
                                <?= $item['tournamenttype_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>