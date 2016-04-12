<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Изменение уровня тренировочной базы</p>
            <?php if (isset($school_array[0]['building_end_date'])) { ?>
                <p class="center warning">
                    Сейчас проходит улучшение молодежной инфраструктуры<br/>
                    Строительство продлится до <?= igosja_ufu_date($school_array[0]['building_end_date']); ?>
                </p>
            <?php } else { ?>
                <table class="striped w100">
                    <tr>
                        <td class="right w50">Команда</td>
                        <td><?= $school_array[0]['team_name']; ?></td>
                    </tr>
                    <tr>
                        <td class="right">Уровень молодежной инфраструктуры</td>
                        <td><?= $school_array[0]['team_school_level']; ?></td>
                    </tr>
                    <tr>
                        <td class="right">Стоимоть строительства следующего уровня</td>
                        <td><?= f_igosja_money($price); ?></td>
                    </tr>
                    <tr>
                        <td class="right">Баланс клуба</td>
                        <td><?= f_igosja_money($team_finance); ?></td>
                    </tr>
                    <tr>
                        <td class="right"><button><a href="school.php?level=1">Увеличить уровень</a></button></td>
                        <td><button><a href="school.php?level=0">Уменьшить уровень</a></button></td>
                    </tr>
                </table>
            <?php } ?>
        </td>
    </tr>
</table>