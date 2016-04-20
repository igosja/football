<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Вместимость стадиона</p>
            <?php if (isset($stadium_array[0]['building_capacity'])) { ?>
                <p class="center warning">
                    Сейчас проходит увеличение стадиона до <?= $stadium_array[0]['building_capacity']; ?> мест.<br/>
                    Строительство продлится до <?= f_igosja_ufu_date($stadium_array[0]['building_end_date']); ?>
                </p>
            <?php } elseif (isset($new_capacity) && isset($increase) && 0 == $increase) { ?>
                <p class="center info">
                    Вы собираетесь уменьшить вместимость своего стадиона<br/>
                    Строительство бесплатно и пройдет мгновенно.<br/>
                    <a href="stadium.php?data[capacity]=<?= $new_capacity; ?>; ?>&ok=1">Изменить вместимость</a> |
                    <a href="stadium.php">Отказаться</a>
                </p>
            <?php } elseif (isset($new_capacity) && isset($increase) && 1 == $increase) { ?>
                <p class="center info">
                    Вы собираетесь увеличить вместимость своего стадиона<br/>
                    Стоимость строительльтва составит <?= f_igosja_money($price); ?>.
                    Строительство продлится до <?= f_igosja_ufu_date(date('d.m.Y', time()+30*24*60*60)); ?><br/>
                    <a href="stadium.php?data[capacity]=<?= $new_capacity; ?>; ?>&ok=1">Изменить вместимость</a> |
                    <a href="stadium.php">Отказаться</a>
                </p>
            <?php } else { ?>
                <form method="GET">
                    <table class="striped w100">
                        <tr>
                            <td class="right w50">Стадион</td>
                            <td><?= $stadium_array[0]['stadium_name']; ?></td>
                        </tr>
                        <tr>
                            <td class="right">Баланс клуба</td>
                            <td><?= f_igosja_money($team_finance); ?></td>
                        </tr>
                        <tr>
                            <td class="right">Текущая вместимость</td>
                            <td><?= $stadium_array[0]['stadium_capacity']; ?></td>
                        </tr>
                        <tr>
                            <td class="right">Новая вместимость</td>
                            <td>
                                <input name="data[capacity]" type="text" />
                            </td>
                        </tr>
                        <tr>
                            <td class="center" colspan="2">
                                <input type="hidden" name="ok" value="0">
                                <input type="submit" value="Изменить вместимость">
                            </td>
                        </tr>
                    </table>
                </form>
            <?php } ?>
        </td>
    </tr>
</table>