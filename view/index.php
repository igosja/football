<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="center header">Добро пожаловать в мир виртуального футбола!</p>
            <p class="justify"><strong>Виртуальная Футбольная Лига</strong> - это игра, в которой вы выступаете в роли тренера виртуальной футбольной команды, футбольный онлайн менеджер. Здесь вы можете выбрать себе команду и привести её к победам и славе.</p>
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
            <p class="justify">Внутри нашего мира - всё как в настоящем футболе: национальные чемпионаты и кубки, Лига чемпионов и чемпионат мира, товарищеские игры.</p>
            <p class="justify">Вы можете сделать карьеру успешного тренера-менеджера, меняя места своей работы или достигнув футбольных вершин со своим первым клубом. Каждый сезон вы можете претендовать на место у руля национальных сборных.</p>
            <p class="justify">В роли тренера ваша задача - определять тактику, стратегию и схему игры команды, выбирать футболистов в стартовый состав. Следить за усталостью и формой футболистов, проводить тренировки. Участвовать в национальном чемпионате и кубке своей страны, претендовать на попадание в Лигу чемпионов.</p>
            <p class="justify">В роли менеджера задачи ещё интереснее - построить инфраструктуру команды (стадион, тренировочную базу и спортивную школу), успешно работать на трансферном рынке, организовывать и принимать участие в товарищеских матчах.</p>
            <p class="justify">Мы предлагаем вам интересное общение и новые знакомства. Всех участников Лиги объединяет только одна вещь - футбол. А участие в игре - бесплатное. Скачивать ничего не нужно. Достаточно иметь возможность посещать сайт хотя бы несколько раз в неделю и работающий почтовый ящик.</p>
        </td>
        <td class="block-page w1">
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
</table>