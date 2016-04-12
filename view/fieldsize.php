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
            <?php } else { ?>
                <form method="POST">
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
                                <button>
                                    <a href="fieldgrass.php?change=1">Заменить газон</a>
                                </button>
                            </td>
                        </tr>
                    </table>
                </form>
            <?php } ?>
        </td>
    </tr>
</table>