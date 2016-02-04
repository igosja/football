<table class="block-table w100">
    <tr>
        <td class="block-page w50">
            <p class="header">Игроки</p>
            <form method="POST">
                <table class="striped w100">
                    <tr>
                        <th>Имя</th>
                        <th class="w5">Поз</th>
                        <th class="w20">Новая поз</th>
                        <th class="w20">Атрибут</th>
                        <th class="w20">Интенсивность</th>
                    </tr>
                    <?php foreach ($player_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="player_home_profile.php?num=<?php print $item['player_id']; ?>">
                                    <?php print $item['name_name']; ?>
                                    <?php print $item['surname_name']; ?>
                                </a>
                            </td>
                            <td class="center">
                                <?php print $item['position_name']; ?>
                            </td>
                            <td class="nopadding">
                                <select class="w100" name="data[<?php print $item['player_id']; ?>][position]">
                                    <option value="0">Не выбрано</option>
                                    <?php if (1 != $item['position_id']) { ?>
                                        <?php foreach ($position_array as $position) { ?>
                                            <?php if ($position['position_id'] != $item['position_id']) { ?>
                                                <option
                                                    value="<?php print $position['position_id']; ?>"
                                                    <?php if ($item['player_training_position_id'] == $position['position_id']) { ?>
                                                        selected
                                                    <?php } ?>
                                                >
                                                    <?php print $position['position_description']; ?>
                                                </option>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="nopadding">
                                <select class="w100" name="data[<?php print $item['player_id']; ?>][attribute]">
                                    <option value="0">Не выбрано</option>
                                    <?php if (1 == $item['position_id']) { ?>
                                        <?php foreach ($gk_attribute_array as $attribute) { ?>
                                            <option
                                                value="<?php print $attribute['attribute_id']; ?>"
                                                <?php if ($item['player_training_attribute_id'] == $attribute['attribute_id']) { ?>
                                                    selected
                                                <?php } ?>
                                            >
                                                <?php print $attribute['attribute_name']; ?>
                                            </option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php foreach ($attribute_array as $attribute) { ?>
                                            <option
                                                value="<?php print $attribute['attribute_id']; ?>"
                                                <?php if ($item['player_training_attribute_id'] == $attribute['attribute_id']) { ?>
                                                    selected
                                                <?php } ?>
                                            >
                                                <?php print $attribute['attribute_name']; ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="center nopadding">
                                <select class="w100" name="data[<?php print $item['player_id']; ?>][intensity]">
                                    <option
                                        value="1"
                                        <?php if (1 == $item['player_training_intensity']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        Низкая
                                    </option>
                                    <option
                                        value="2"
                                        <?php if (2 == $item['player_training_intensity']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        Средняя
                                    </option>
                                    <option
                                        value="3"
                                        <?php if (3 == $item['player_training_intensity']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        Высокая
                                    </option>
                                </select>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="center" colspan="5">
                            <input type="submit" value="Сохранить" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>