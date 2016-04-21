<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Изменение уровня тренировочной базы</p>
            <?php if (isset($base_array[0]['building_end_date'])) { ?>
                <p class="center warning">
                    Сейчас проходит улучшение тернировчной базы<br />
                    Строительство продлится до <?= f_igosja_ufu_date($base_array[0]['building_end_date']); ?>
                </p>
            <?php } elseif (isset($level) && 1 == $level) { ?>
                <p class="center info">
                    Вы собираетесь увеличить уровень вашей тренирочной базы<br />
                    Стоимость строительльтва составит <?= f_igosja_money($price); ?>.
                    Строительство продлится до <?= f_igosja_ufu_date(date('d.m.Y', time()+30*24*60*60)); ?><br />
                    <a href="base.php?level=1&ok=1">Начать строительство</a> |
                    <a href="base.php">Отказаться от строительства</a>
                </p>
            <?php } elseif (isset($level) && 0 == $level) { ?>
                <p class="center info">
                    Вы собираетесь уменьшить уровень вашей тренирочной базы<br />
                    Строительство бесплатно и пройдет мгновенно.<br />
                    <a href="base.php?level=0&ok=1">Провести строительство</a> |
                    <a href="base.php">Отказаться от строительства</a>
                </p>
            <?php } else { ?>
                <table class="striped w100">
                    <tr>
                        <td class="right w50">Команда</td>
                        <td><?= $base_array[0]['team_name']; ?></td>
                    </tr>
                    <tr>
                        <td class="right">Уровень тренировочной базы</td>
                        <td><?= $base_array[0]['team_training_level']; ?></td>
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
                        <td class="right"><button><a href="base.php?level=1&ok=0">Увеличить уровень</a></button></td>
                        <td><button><a href="base.php?level=0&ok=0">Уменьшить уровень</a></button></td>
                    </tr>
                </table>
            <?php } ?>
        </td>
    </tr>
</table>