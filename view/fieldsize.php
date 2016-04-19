<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Изменение размеров поля</p>
            <?php if (isset($stadium_array[0]['building_end_date'])) { ?>
                <p class="center warning">
                    Сейчас проходит изменение размеров поля до
                    <?= $stadium_array[0]['building_length']; ?>x<?= $stadium_array[0]['building_width']; ?>м<br/>
                    Изменения вступят в силу после игр ближайшего дня
                </p>
            <?php } elseif (isset($data)) { ?>
                <p class="center info">
                    Вы собираетесь изменить размеры газона своего стадиона<br/>
                    Работы продлятся до <?= date('d.m.Y', time()+24*60*60); ?><br/>
                    <a href="fieldsize.php?data[length]=<?= $data['length']; ?>&data[width]=<?= $data['width']; ?>&ok=1">Изменить размеры</a> |
                    <a href="fieldsize.php">Отказаться</a>
                </p>
            <?php } else { ?>
                <form method="GET">
                    <table class="striped w100">
                        <tr>
                            <td class="right w50">Стадион</td>
                            <td><?= $stadium_array[0]['stadium_name']; ?></td>
                        </tr>
                        <tr>
                            <td class="right">Текущие размеры</td>
                            <td>Длина: <?= $stadium_array[0]['stadium_length']; ?> м, ширина: <?= $stadium_array[0]['stadium_width']; ?> м</td>
                        </tr>
                        <tr>
                            <td class="right">Новые размеры</td>
                            <td>
                                Длина: <input type="text" name="data[length]" placeholder="от 100 до 110"> м,<br/>
                                Ширина: <input type="text" name="data[width]" placeholder="от 64 до 75"> м
                            </td>
                        </tr>
                        <tr>
                            <td class="center" colspan="2">
                                <input type="hidden" name="ok" value="0" />
                                <input type="submit" value="Изменить размеры" />
                            </td>
                        </tr>
                    </table>
                </form>
            <?php } ?>
        </td>
    </tr>
</table>