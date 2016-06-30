<form action="" method="POST">
    <table class="block-table w100">
        <tr>
            <td class="block-page w50">
                <p class="header">Игроки</p>
                <table class="striped w100">
                    <tr>
                        <th>Игрок</th>
                        <th class="w15">Штрафные</th>
                        <th class="w15">Угловые</th>
                        <th class="w15">Ауты</th>
                    </tr>
                    <?php foreach ($player_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                    <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                </a>
                            </td>
                            <td class="center"><?= $item['free_kick']; ?></td>
                            <td class="center"><?= $item['corner']; ?></td>
                            <td class="center"><?= $item['out']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
            <td class="block-page">
                <p class="header">Угловые</p>
                <table class="striped w100">
                    <tr>
                        <th class="w50">Левая сторона</td>
                        <th class="w50">Правая сторона</td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[corner_left][1]" id="select-corner-left-1" class="select-corner-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_corner_left_player_id_1'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[corner_right][1]" id="select-corner-right-1" class="select-corner-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_corner_right_player_id_1'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[corner_left][2]" id="select-corner-left-2" class="select-corner-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_corner_left_player_id_2'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[corner_right][2]" id="select-corner-right-2" class="select-corner-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_corner_right_player_id_2'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[corner_left][3]" id="select-corner-left-3" class="select-corner-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_corner_left_player_id_3'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[corner_right][3]" id="select-corner-right-3" class="select-corner-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_corner_right_player_id_3'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[corner_left][4]" id="select-corner-left-4" class="select-corner-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_corner_left_player_id_4'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[corner_right][4]" id="select-corner-right-4" class="select-corner-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_corner_right_player_id_4'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[corner_left][5]" id="select-corner-left-5" class="select-corner-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_corner_left_player_id_5'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[corner_right][5]" id="select-corner-right-5" class="select-corner-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_corner_right_player_id_5'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <p class="header">Штрафные</p>
                <table class="striped w100">
                    <tr>
                        <th>Левая сторона</td>
                        <th>Правая сторона</td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[freekick_left][1]" id="select-freekick-left-1" class="select-freekick-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_freekick_left_player_id_1'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[freekick_right][1]" id="select-freekick-right-1" class="select-freekick-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_freekick_right_player_id_1'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[freekick_left][2]" id="select-freekick-left-2" class="select-freekick-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_freekick_left_player_id_2'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[freekick_right][2]" id="select-freekick-right-2" class="select-freekick-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_freekick_right_player_id_2'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[freekick_left][3]" id="select-freekick-left-3" class="select-freekick-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_freekick_left_player_id_3'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[freekick_right][3]" id="select-freekick-right-3" class="select-freekick-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_freekick_right_player_id_3'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[freekick_left][4]" id="select-freekick-left-4" class="select-freekick-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_freekick_left_player_id_4'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[freekick_right][4]" id="select-freekick-right-4" class="select-freekick-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_freekick_right_player_id_4'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[freekick_left][5]" id="select-freekick-left-5" class="select-freekick-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_freekick_left_player_id_5'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[freekick_right][5]" id="select-freekick-right-5" class="select-freekick-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_freekick_right_player_id_5'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <p class="header">Ауты</p>
                <table class="striped w100">
                    <tr>
                        <th>Левая сторона</th>
                        <th>Правая сторона</th>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[out_left][1]" id="select-out-left-1" class="select-out-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_out_left_player_id_1'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[out_right][1]" id="select-out-right-1" class="select-out-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_out_right_player_id_1'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[out_left][2]" id="select-out-left-2" class="select-out-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_out_left_player_id_2'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[out_right][2]" id="select-out-right-2" class="select-out-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_out_right_player_id_2'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[out_left][3]" id="select-out-left-3" class="select-out-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_out_left_player_id_3'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[out_right][3]" id="select-out-right-3" class="select-out-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_out_right_player_id_3'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[out_left][4]" id="select-out-left-4" class="select-out-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_out_left_player_id_4'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[out_right][4]" id="select-out-right-4" class="select-out-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_out_right_player_id_4'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <select name="data[out_left][5]" id="select-out-left-5" class="select-out-left w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_out_left_player_id_5'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="data[out_right][5]" id="select-out-right-5" class="select-out-right w100">
                                <option value="0">-</option>
                                <?php foreach ($player_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($standard_array[0]['country_out_right_player_id_5'] == $item['player_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="center" colspan="2">
                            <input type="submit" value="Сохранить" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
<script>
    var player_array =
    [
        <?php foreach ($player_array as $item) { ?>
            [<?= $item['player_id']; ?>, '<?= $item['name_name']; ?> <?= $item['surname_name']; ?>'],
        <?php } ?>
    ];
</script>