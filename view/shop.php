<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header">Личный счет</p>
            <table class="striped w100">
                <tr>
                    <td colspan="2">
                        <p class="justify">Развитие команды не требует обязательного совершения покупок в магазине, но если вы не привыкли ждать, хотите "всё и сразу" и имеете возможность "ускорить процесс", то добро пожаловать в магазин игровых товаров! Цены для разных команд разные - чем сильнее команда, тем сложнее её усилить с помощью магазина.</p>
                        <p class="justify">Пополнение производится с использованием системы электронных платежей <a href="http://http://www.free-kassa.ru//" target="_blank">Free-kassa©.</p>
<!--                        <p class="justify">Пополнение производится с использованием системы электронных платежей <a href="http://www.pay2pay.com/" target="_blank">Pay2Pay©. [<a href="javascript:;" id="pay2pay-button">Подробнее</a>]</p>-->
                    </td>
                </tr>
                <tr style="display: none;" id="pay2pay-description">
                    <td colspan="2">
                        <p class="center"><strong>Порядок оплаты через Pay2Pay</strong></p>
                        <br/>
                        <p class="justify">Система Pay2Pay© позволяет совершать платежи следующими способами:</p>
                        <ul>
                            <li>банковские карты (VISA, MasterCard/Maestro)</li>
                            <li>электронные кошельки (QIWI, Яндекс.Деньги, Webmoney)</li>
                            <li>онлайн-банкинг (Альфа-клик, QBank)</li>
                            <li>терминалы самообслуживания.</li>
                        </ul>
                        <p class="justify">Пополнить счет можно посредством любого из перечисленных способов. В случае возврата
                        средства будут отправлены по тем же реквизитам, с которых производилась оплата (при
                        наличии технической возможности).</p>
                        <p class="justify">Оплата заказа осуществляется по следующей схеме:</p>
                        <ol>
                            <li>После ввода суммы пополнения и нажатия на кнопку "Пополнить" произойдет перенаправление на защищенную страницу
                                платежной системы (Мерчант Pay2Pay)</li>
                            <li>Выберите способ оплаты и осуществите платеж. Платежная система пришлет уведомление об
                        оплате администратору сайта.</li>
                            <li>После совершения оплаты Вы будете возвращены на сайт, где Вам будет сообщено о
                        результате транзакции.</li>
                        </ol>
                        <br/>
                        <p class="center"><strong>Гарантии безопасности</strong></p>
                        <br/>
                        <p class="justify">Обеспечить безопасность оплаты через Pay2Pay© позволяют следующие технологии:</p>
                        <ul>
                            <li>запись каждого этапа всех транзакций в системе;</li>
                            <li>постоянный фрод-мониторинг всех платежей;</li>
                            <li>доступ клиента к детальной информации о транзакциях;</li>
                            <li>осуществление контроля и сверки каждого платежа;</li>
                            <li>применение безопасных соединений TLS и SSL.</li>
                        </ul>
                        <p class="justify">Применение безопасного соединения SSL позволяет получить привязку к каждому конкретному
                        серверу интернет-магазина. На сегодняшний день SSL (SecureSocketLayer) является одной из
                        самых лучших технологий защиты электронных данных на мировом рынке, которая использует
                        метод аутентификации взаимодействующих сторон (проверку подлинности предъявленного
                        пользователем идентификатора) и шифрование данных с симметричными и ассиметричными
                        алгоритмами.</p>
                        <p class="justify">Процессинговый центр, который обеспечивает работу платежных сервисов, соответствует
                        требованиям международного стандарта PCI DSS версии 2.0, что подтверждается аудитом по
                        правилам первого (наивысшего) уровня Level 1 международных платежных систем Visa и
                        MasterCard.</p>
                    </td>
                </tr>
                <tr>
                    <td class="w50">Баланс личного счета</td>
                    <td class="right"><?= $user_array[0]['user_money']; ?> ед.</td>
                </tr>
                <tr>
                    <td class="center" colspan="2">
                        <form method="POST">
                            Сумма пополнения, ед.:
                            <input name="data[sum]" type="text" size="5" />
                            <input type="submit" value="Пополнить" />
                        </form>
                    </td>
                </tr>
                <tr>
                    <td class="center" colspan="2">
                        Курс обмена: 1 ед. на счету = 50 руб.
                        <br />
                        <a href="//www.free-kassa.ru/"><img src="//www.free-kassa.ru/img/fk_btn/4.png"></a>
<!--                        <a href="http://www.pay2pay.com/" target="_blank">-->
<!--                            <img src="/img/pay2pay.png">-->
<!--                        </a>-->
                    </td>
                </tr>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Игровые товары</p>
            <table class="striped w100">
                <tr>
                    <td>1 балл для улучшения характеристик игрока своей команды</td>
                    <td class="right">
                        <a href="shop.php?point=1" class="button-link">
                            <button>
                                Купить за 1 ед.
                            </button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Дополнительная позиция для игрока своей команды</td>
                    <td class="right">
                        <a href="shop.php?position=1" class="button-link">
                            <button>
                                Купить за 5 ед.
                            </button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>1 млн. $ на счёт своей команды</td>
                    <td class="right">
                        <a href="shop.php?money=1" class="button-link">
                            <button>
                                Купить за 10 ед.
                            </button>
                        </a>
                    </td>
                </tr>
            </table>
            <p class="justify"><?= SPACE; ?></p>
            <p class="justify">
                Если вам нравится эта игра, если вы хотите пользоваться более комфортным интерфейсом без рекламы,
                а может у вас просто есть желание и возможность поддержать нашу дальнейшую работу -
                рекомендуем вам оплатить небольшой взнос и стать VIP-менеджером. Спасибо!
            </p>
            <table class="striped w100">
                <tr>
                    <td>Вступить в VIP-клуб на 15 дней</td>
                    <td class="right">
                        <a href="shop.php?vip=15" class="button-link">
                            <button>
                                Купить за 2 ед.
                            </button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Вступить в VIP-клуб на 30 дней</td>
                    <td class="right">
                        <a href="shop.php?vip=30" class="button-link">
                            <button>
                                Купить за 3 ед.
                            </button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Вступить в VIP-клуб на 60 дней</td>
                    <td class="right">
                        <a href="shop.php?vip=60" class="button-link">
                            <button>
                                Купить за 5 ед.
                            </button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Вступить в VIP-клуб на 180 дней</td>
                    <td class="right">
                        <a href="shop.php?vip=180" class="button-link">
                            <button>
                                Купить за 10 ед.
                            </button>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Вступить в VIP-клуб на 365 дней</td>
                    <td class="right">
                        <a href="shop.php?vip=365" class="button-link">
                            <button>
                                Купить за 15 ед.
                            </button>
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>