<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Изменение уровня молодежной инфраструктуры</p>
            <?php if (isset($school_array[0]['shedule_date'])) { ?>
                <p class="center warning">
                    Сейчас проходит улучшение молодежной инфраструктуры<br />
                    Строительство продлится до <?= f_igosja_ufu_date($school_array[0]['shedule_date']); ?>
                </p>
            <?php } elseif (isset($level) && 1 == $level) { ?>
                <p class="center">
                    Вы собираетесь увеличить уровень вашей молодежной инфраструктуры<br />
                    Стоимость строительльтва составит <?= f_igosja_money($price); ?>.
                    Строительство продлится до <?= f_igosja_ufu_date(date('d.m.Y', time()+30*24*60*60)); ?>
                </p>
                <p class="center">
                    <a href="school.php?level=1&ok=1" class="button-link"><button>Начать строительство</button></a>
                    <a href="school.php" class="button-link"><button>Отказаться от строительства</button></a>
                </p>
            <?php } elseif (isset($level) && 0 == $level) { ?>
                <p class="center">
                    Вы собираетесь уменьшить уровень вашей молодежной инфраструктуры<br />
                    Строительство бесплатно и пройдет мгновенно.
                </p>
                <p class="center">
                    <a href="school.php?level=0&ok=1" class="button-link"><button>Провести строительство</button></a>
                    <a href="school.php" class="button-link"><button>Отказаться от строительства</button></a>
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
                        <td class="right"><a href="school.php?level=1&ok=0" class="button-link"><button>Увеличить уровень</button></a></td>
                        <td><a href="school.php?level=0&ok=0" class="button-link"><button>Уменьшить уровень</button></a></td>
                    </tr>
                </table>
            <?php } ?>
        </td>
    </tr>
</table>