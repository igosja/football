<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">
                <a href="javascript:;" class="finance-link active" data-id="1">Итог</a>
                <a href="javascript:;" class="finance-link" data-id="2">Доходы</a>
                <a href="javascript:;" class="finance-link" data-id="3">Расходы</a>
                <a href="javascript:;" class="finance-link" data-id="4">Список операций</a>
            </p>
            <table class="w100">
                <tr>
                    <td class="center">
                        <form method="GET" id="page-form">
                            Сезон:
                            <select name="season" id="page-select">
                                <?php for ($i=1; $i<=$igosja_season_id; $i++) { ?>
                                    <option value="<?= $i; ?>"
                                        <?php if ($get_season == $i) { ?>
                                            selected
                                        <?php } ?>
                                    ><?= $i; ?></option>
                                <?php } ?>
                            </select>
                        </form>
                    </td>
                </tr>
            </table>
            <?php foreach ($finance_array as $item) { ?>
                <table class="striped w100" id="finance-1">
                    <tr>
                        <th>Статьи</th>
                        <th class="w20">Этот сезон</th>
                        <th class="w20">Прошлый сезон</th>
                    </tr>
                    <tr>
                        <td>Доходы</td>
                        <td class="right"><?= f_igosja_money($item['finance_income']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_income'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_income']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Расходы</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Затраты по зарплате</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense_salary']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense_salary'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense_salary']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Прибыль (Убытки)</td>
                        <td class="right"><?= f_igosja_money($item['finance_income'] - $item['finance_expense']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_income'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_income'] - $finance_prev_array[0]['finance_expense']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Баланс</td>
                        <td class="right"><?= f_igosja_money($team_array[0]['team_finance']); ?></td>
                        <td class="right"></td>
                    </tr>
                </table>
                <table class="striped w100" id="finance-2" style="display: none;">
                    <tr>
                        <th>Статьи</th>
                        <th class="w20">Этот сезон</th>
                        <th class="w20">Прошлый сезон</th>
                    </tr>
                    <tr>
                        <td>Билеты</td>
                        <td class="right"><?= f_igosja_money($item['finance_income_ticket']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_income_ticket'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_income_ticket']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Сезонные абонементы</td>
                        <td class="right"><?= f_igosja_money($item['finance_income_subscription']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_income_subscription'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_income_subscription']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Доход от ТВ трансляций</td>
                        <td class="right"><?= f_igosja_money($item['finance_income_tv']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_income_tv'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_income_tv']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Призовые</td>
                        <td class="right"><?= f_igosja_money($item['finance_income_prize']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_income_prize'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_income_prize']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Трансферные доходы</td>
                        <td class="right"><?= f_igosja_money($item['finance_income_transfer']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_income_transfer'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_income_transfer']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Спонсорские выплаты</td>
                        <td class="right"><?= f_igosja_money($item['finance_income_sponsor']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_income_sponsor'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_income_sponsor']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Продажа клубной артибутики</td>
                        <td class="right"><?= f_igosja_money($item['finance_income_attributes']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_income_attributes'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_income_attributes']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Полученные инвестиции</td>
                        <td class="right"><?= f_igosja_money($item['finance_income_donat']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_income_donat'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_income_donat']); ?><?php } ?></td>
                    </tr>
                </table>
                <table class="striped w100" id="finance-3" style="display: none;">
                    <tr>
                        <th>Статьи</th>
                        <th class="w20">Этот сезон</th>
                        <th class="w20">Прошлый сезон</th>
                    </tr>
                    <tr>
                        <td>Зарплата</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense_salary']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense_salary'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense_salary']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Скаутские расходы</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense_scout']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense_scout'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense_scout']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Транспортные расходы</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense_transport']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense_transport'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense_transport']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Трансферные расходы</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense_transfer']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense_transfer'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense_transfer']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Выплаты агентам игроков</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense_agent']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense_agent'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense_agent']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Строительство базы и стадиона</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense_build']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense_build'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense_build']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Содержание базы команды</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense_base']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense_base'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense_base']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Содержание стадиона</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense_stadium']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense_stadium'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense_stadium']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Выплаты по займам</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense_loan']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense_loan'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense_loan']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Штрафы</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense_penalty']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense_penalty'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense_penalty']); ?><?php } ?></td>
                    </tr>
                    <tr>
                        <td>Налоги</td>
                        <td class="right"><?= f_igosja_money($item['finance_expense_tax']); ?></td>
                        <td class="right"><?php if (isset($finance_prev_array[0]['finance_expense_tax'])) { ?><?= f_igosja_money($finance_prev_array[0]['finance_expense_tax']); ?><?php } ?></td>
                    </tr>
                </table>
            <?php } ?>
            <table class="striped w100" id="finance-4" style="display: none;">
                <tr>
                    <th class="w10">Дата</th>
                    <th>Операция</th>
                    <th class="w20">Сумма</th>
                </tr>
                <?php foreach ($history_array as $item) { ?>
                    <tr>
                        <td class="center"><?= f_igosja_ufu_date($item['historyfinanceteam_date']); ?></td>
                        <td><?= $item['historytext_name']; ?></td>
                        <td class="right"><?= f_igosja_money($item['historyfinanceteam_value']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>