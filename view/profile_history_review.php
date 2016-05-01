<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Обзор</p>
            <table class="striped w100">
                <tr>
                    <th colspan="2">Статистика менеджера</th>
                    <th colspan="2">Статистика игрока</th>
                </tr>
                <tr>
                    <td class="w35">Количество клубных постов в карьере</td>
                    <td class="center w15"><?= $user_array[0]['user_team']; ?></td>
                    <td class="w35">Число купленных игроков</td>
                    <td class="center w15"><?= $user_array[0]['user_buy_player']; ?></td>
                </tr>
                <tr>
                    <td>Количество сборных постов в карьере</td>
                    <td class="center"><?= $user_array[0]['user_national']; ?></td>
                    <td>Общая стоимость купленных игроков</td>
                    <td class="center"><?= f_igosja_money($user_array[0]['user_buy_price']); ?></td>
                </tr>
                <tr>
                    <td>Наибольшее время в клубе</td>
                    <td class="center"><?= $user_array[0]['user_team_time_max']; ?> дн.</td>
                    <td>Количество проданных игроков</td>
                    <td class="center"><?= $user_array[0]['user_sell_player']; ?></td>
                </tr>
                <tr>
                    <td>Наименьшее время в клубе</td>
                    <td class="center"><?= $user_array[0]['user_team_time_min']; ?> дн.</td>
                    <td>Общая стоимость проданных игроков</td>
                    <td class="center"><?= f_igosja_money($user_array[0]['user_sell_price']); ?></td>
                </tr>
                <tr>
                    <td>Число трофеев</td>
                    <td class="center"><?= $user_array[0]['user_trophy']; ?></td>
                    <td>Наибольшая потраченная сумма</td>
                    <td class="center"><?= f_igosja_money($user_array[0]['user_sell_max']); ?></td>
                </tr>
                <tr>
                    <td>Общее игровое время</td>
                    <td class="center"><?= $career_array[0]['day']; ?> дн.</td>
                    <td>Наибольшая полученная сумма</td>
                    <td class="center"><?= f_igosja_money($user_array[0]['user_buy_max']); ?></td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th colspan="4">Статистика карьеры</th>
                </tr>
                <tr>
                    <td class="w35">Сыграно матчей</td>
                    <td class="center w15"><?= $career_array[0]['game']; ?></td>
                    <td class="w35">Мячей забито</td>
                    <td class="center w15"><?= $career_array[0]['score']; ?></td>
                </tr>
                <tr>
                    <td>Побед</td>
                    <td class="center"><?= $career_array[0]['win']; ?></td>
                    <td>Мячей пропущено</td>
                    <td class="center"><?= $career_array[0]['pass']; ?></td>
                </tr>
                <tr>
                    <td>Ничьих</td>
                    <td class="center"><?= $career_array[0]['draw']; ?></td>
                    <td>Разница мячей</td>
                    <td class="center"><?= $career_array[0]['score'] - $career_array[0]['pass']; ?></td>
                </tr>
                <tr>
                    <td>Поражений</td>
                    <td class="center"><?= $career_array[0]['loose']; ?></td>
                    <td>Процент побед</td>
                    <td class="center">
                    <?php

                    if (0 == $career_array[0]['game'])
                    {
                        print 0;
                    }
                    else
                    {
                        print round($career_array[0]['win'] / $career_array[0]['game'] * 100);
                    }

                    ?> %</td>
                </tr>
            </table>
        </td>
    </tr>
</table>