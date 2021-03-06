<table class="block-table w100">
    <tr>
        <td class="block-page" colspan="2">
            <p class="header">Общая информация</p>
            <p class="center">На этой странице вы можете провести платную тренировку своего игрока.</p>
            <p class="center">
                Доступные баллы для улучшения характеристик игроков:
                <strong><?= $user_array[0]['user_money_training']; ?></strong>
                <span class="grey">[<a href="shop.php">Приобрести еще</a>]</span>
            </p>
            <p class="center">
                Доступные тернировки позиций:
                <strong><?= $user_array[0]['user_money_position']; ?></strong>
                <span class="grey">[<a href="shop.php">Приобрести еще</a>]</span>
            </p>
        </td>
    </tr>
    <tr>
        <td class="block-page w25">
            <p class="header">Позиции</p>
            <table class="w100">
                <tr>
                    <td class="relative w1">
                        <div>
                        <img alt="Позиции" src="/img/field/field-108.png" />
                        <?php foreach ($playerposition_array as $item) { ?>
                            <img
                                alt="<?= $item['position_description']; ?>"
                                src="/img/position/<?= f_igosja_position_icon($item['playerposition_value']); ?>.png"
                                style="position: absolute; top: <?= 150 - $item['position_coordinate_x'] * 15 - 10; ?>px; left: <?= 1 + $item['position_coordinate_y'] * 15; ?>px;"
                                title="<?= $item['position_description']; ?>"
                            />
                        <?php } ?>
                        </div>
                    </td>
                    <td>
                        <table class="striped w100">
                            <tr>
                                <th class="w50">Позиция</th>
                                <th>Способность</th>
                            </tr>
                            <?php foreach ($playerposition_array as $item) { ?>
                                <tr>
                                    <td><?= $item['position_name']; ?></td>
                                    <td class="right">
                                        <?= $item['playerposition_value']; ?> %
                                        <?php if (100 > $item['playerposition_value']) { ?>
                                            <a href="player_home_training.php?num=<?= $num; ?>&position=<?= $item['position_id']; ?>">
                                                +
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php foreach ($position_array as $item) { ?>
                                <tr>
                                    <td><?= $item['position_name']; ?></td>
                                    <td class="right">
                                        <a href="player_home_training.php?num=<?= $num; ?>&position=<?= $item['position_id']; ?>">
                                            +
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <td class="block-page">
            <p class="header">Характеристики</p>
            <table class="w100">
                <tr>
                    <?php for ($i=0; $i<$count_attribute; $i++) { ?>
                        <?php

                        if (!isset($attribute_array[$i-1]['attributechapter_name']) ||
                            $attribute_array[$i-1]['attributechapter_name'] != $attribute_array[$i]['attributechapter_name'])
                        {

                        ?>
                            <td>
                                <table class="striped w100">
                                    <tr>
                                        <th colspan="2"><?= $attribute_array[$i]['attributechapter_name']; ?></th>
                                    </tr>
                        <?php } ?>
                            <tr>
                                <td><?= $attribute_array[$i]['attribute_name']; ?></td>
                                <td class="center w33">
                                    <?php if (isset($authorization_team_id) && $authorization_team_id == $player_array[0]['team_id']) { ?>
                                        <?= $attribute_array[$i]['playerattribute_value']; ?>
                                        <a href="player_home_training.php?num=<?= $num; ?>&char=<?= $attribute_array[$i]['attribute_id']; ?>">+</a>
                                    <?php } else { ?>
                                        ?
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php

                        if (!isset($attribute_array[$i+1]['attributechapter_name']) ||
                            $attribute_array[$i+1]['attributechapter_name'] != $attribute_array[$i]['attributechapter_name'])
                        {

                        ?>
                                </table>
                            </td>
                        <?php } ?>
                    <?php } ?>
                </tr>
            </table>
        </td>
    </tr>
</table>