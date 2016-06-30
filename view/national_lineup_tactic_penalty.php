<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Игроки</p>
            <table class="striped w100">
                <tr>
                    <th>Игрок</th>
                    <th class="w10">Поз</th>
                    <th class="w15">Самообладание</th>
                    <th class="w15">Пенальти</th>
                </tr>
                <?php foreach ($player_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="player_home_profile.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="center"><?= $item['position_name']; ?></td>
                        <td class="center"><?= $item['composure']; ?></td>
                        <td class="center"><?= $item['penalty']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
        <td class="block-page w50">
            <p class="header">Пенальти</p>
            <form method="POST">
                <table class="striped w100">
                    <tr>
                        <td class="vcenter w35">Первый игрок</td>
                        <td class="nopadding">
                            <select id="select-penalty-1" class="select-penalty w100" name="data[1]">
                                <option value="0">-</option>
                                <?php foreach ($penaltyplayer_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($penalty_array[0]['country_penalty_player_id_1'] == $item['player_id']) { ?>
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
                        <td class="vcenter">Второй игрок</td>
                        <td class="nopadding">
                            <select id="select-penalty-2" class="select-penalty w100" name="data[2]">
                                <option value="0">-</option>
                                <?php foreach ($penaltyplayer_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($penalty_array[0]['country_penalty_player_id_2'] == $item['player_id']) { ?>
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
                        <td class="vcenter">Третий игрок</td>
                        <td class="nopadding">
                            <select id="select-penalty-3" class="select-penalty w100" name="data[3]">
                                <option value="0">-</option>
                                <?php foreach ($penaltyplayer_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($penalty_array[0]['country_penalty_player_id_3'] == $item['player_id']) { ?>
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
                        <td class="vcenter">Четвертый игрок</td>
                        <td class="nopadding">
                            <select id="select-penalty-4" class="select-penalty w100" name="data[4]">
                                <option value="0">-</option>
                                <?php foreach ($penaltyplayer_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($penalty_array[0]['country_penalty_player_id_4'] == $item['player_id']) { ?>
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
                        <td class="vcenter">Пятый игрок</td>
                        <td class="nopadding">
                            <select id="select-penalty-5" class="select-penalty w100" name="data[5]">
                                <option value="0">-</option>
                                <?php foreach ($penaltyplayer_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($penalty_array[0]['country_penalty_player_id_5'] == $item['player_id']) { ?>
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
                        <td class="vcenter">Шестой игрок</td>
                        <td class="nopadding">
                            <select id="select-penalty-6" class="select-penalty w100" name="data[6]">
                                <option value="0">-</option>
                                <?php foreach ($penaltyplayer_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($penalty_array[0]['country_penalty_player_id_6'] == $item['player_id']) { ?>
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
                        <td class="vcenter">Седьмой игрок</td>
                        <td class="nopadding">
                            <select id="select-penalty-7" class="select-penalty w100" name="data[7]">
                                <option value="0">-</option>
                                <?php foreach ($penaltyplayer_array as $item) { ?>
                                    <option value="<?= $item['player_id']; ?>"
                                        <?php if ($penalty_array[0]['country_penalty_player_id_7'] == $item['player_id']) { ?>
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
            </form>
        </td>
    </tr>
</table>
<script>
    var player_array =
    [
        <?php foreach ($penaltyplayer_array as $item) { ?>
            [<?= $item['player_id']; ?>, '<?= $item['name_name']; ?> <?= $item['surname_name']; ?>'],
        <?php } ?>
    ];
</script>