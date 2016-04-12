<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Изменение размеров поля</p>
            <?php if (isset($stadium_array[0]['building_end_date'])) { ?>
                <p class="center warning">
                    Сейчас проходит замена газона<br/>
                    Работы завершатся после игр ближайшего дня
                </p>
            <?php } else { ?>
                <table class="striped w100">
                    <tr>
                        <td class="right w50">Стадион</td>
                        <td><?= $stadium_array[0]['stadium_name']; ?></td>
                    </tr>
                    <tr>
                        <td class="right">Состояние газона</td>
                        <td><?= $stadium_array[0]['stadiumquality_name']; ?></td>
                    </tr>
                        <td class="right">Стоимоть замены газона</td>
                        <td><?= f_igosja_money($price); ?></td>
                    </tr>
                    <tr>
                        <td class="right">Баланс клуба</td>
                        <td><?= f_igosja_money($team_finance); ?></td>
                    </tr>
                    <tr>
                        <td class="center" colspan="2">
                            <button>
                                <a href="fieldgrass.php?change=1">Заменить газон</a>
                            </button>
                        </td>
                    </tr>
                </table>
            <?php } ?>
        </td>
    </tr>
</table>