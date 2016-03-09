<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header">Личный счет</p>
            <table class="striped w100">
                <tr>
                    <td colspan="2">
                        <p class="justify">Развитие команды не требует обязательного совершения покупок в магазине, но если вы не привыкли ждать, хотите "всё и сразу" и имеете возможность "ускорить процесс", то добро пожаловать в магазин игровых товаров! Цены для разных команд разные - чем сильнее команда, тем сложнее её усилить с помощью магазина.</p>
                        <p class="justify">Покупка происходит через сервис <a href="http://robokassa.ru/ru/" target="_blank">Robokassa</a>.</p>
                    </td>
                </tr>
                <tr>
                    <td class="w50">Баланс личного счета</td>
                    <td class="right"><?php print $user_array[0]['user_money']; ?> ед.</td>
                </tr>
                <tr>
                    <td class="center" colspan="2">
                        <form method="POST">
                            Сумма пополнения:
                            <input name="data[sum]" type="text" size="1">
                            <input type="submit" value="Пополнить" />
                        </form>
                    </td>
                </tr>
                <tr>
                    <td class="center" colspan="2">
                        <a href="https://passport.webmoney.ru/asp/certview.asp?wmid=274662367507" target="_blank">
                            <img src="img/webmoney.png">
                        </a>
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
                        <button>
                            <a href="shop.php?point=1">
                                Купить за 1 единицу
                            </a>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>Дополнительная позиция для игрока своей команды</td>
                    <td class="right">
                        <button>
                            <a href="shop.php?position=1">
                                Купить за 5 единиц
                            </a>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>1 млн. $ на счёт своей команды</td>
                    <td class="right">
                        <button>
                            <a href="shop.php?money=1">
                                Купить за 10 единиц
                            </a>
                        </button>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>