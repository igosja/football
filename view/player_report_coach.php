<table class="block-table w100">
    <tr>
        <td class="block-page" colspan="2">
            <p class="header">Отчет</p>
            <table class="center w100">
                <tr>
                    <td>Потенциальные способности</td>
                </tr>
                <tr>
                    <td>
                        <?php print f_igosja_five_star($player_array[0]['player_ability'], 20); ?>
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
                    <td>Роль</td>
                </tr>
                <tr>
                    <td><h5><?php print $player_array[0]['position_description']; ?></h5></td>
                    <td><h5><?php print $player_array[0]['role_name']; ?></h5></td>
                </tr>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Пригодность</p>
            <table class="striped w100">
                <?php foreach ($player_array as $item) { ?>
                    <tr>
                        <td class="w50"><?php print $item['role_name']; ?></td>
                        <td class="center">
                            <?php print f_igosja_five_star($item['player_ability'], 12); ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>