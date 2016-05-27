<table class="block-table w100">
    <tr>
        <td class="block-page" colspan="2">
            <p class="header">Отчет</p>
            <table class="center w100">
                <tr>
                    <td class="w50">Потенциальные способности</td>
                    <td>Текущие способности</td>
                </tr>
                <tr>
                    <td>
                        <?= f_igosja_five_star($player_array[0]['player_ability'], 20); ?>
                    </td>
                    <td>
                        <?= f_igosja_five_star($player_array[0]['player_power'], 20); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="block-page w50">
            <p class="header">Позиция</p>
            <table class="center w100">
                <tr>
                    <td class="w50">Позиция</td>
                    <td>Лучшая роль</td>
                </tr>
                <tr>
                    <td><h5><?= $player_array[0]['position_description']; ?></h5></td>
                    <td><h5><?= $player_array[0]['role_name']; ?></h5></td>
                </tr>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Пригодность</p>
            <table class="striped w100">
                <?php for ($i=0; $i<$count_player; $i++) { ?>
                    <?php if ($i == $best_place) { $best_bonus = 10; } else { $best_bonus = 0; } ?>
                    <tr>
                        <td class="w50"><?= $player_array[$i]['role_name']; ?></td>
                        <td class="center">
                            <?= f_igosja_five_star($player_array[$i]['player_power'] + $best_bonus, 12); ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>