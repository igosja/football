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
                                <a href="player_home_profile.php?num={$player_array[i].player_id}">
                                    {$player_array[i].name_name}
                                    {$player_array[i].surname_name}
                                </a>
                            </td>
                            <td class="center">
                                {$player_array[i].position_name}
                            </td>
                            <td class="nopadding">
                                <select class="w100" name="data[{$player_array[i].player_id}][position]">
                                    <option value="0">Не выбрано</option>
                                    <?php foreach ($position_array as $position) { ?>
                                        {if ($position_array[j].position_id != $player_array[i].position_id)}
                                            <option
                                                value="{$position_array[j].position_id}"
                                                {if ($player_array[i].player_training_position_id == $position_array[j].position_id)}
                                                    selected
                                                <?php } ?>
                                            >
                                                {$position_array[j].position_description}
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="nopadding">
                                <select class="w100" name="data[{$player_array[i].player_id}][attribute]">
                                    <option value="0">Не выбрано</option>
                                    {if (1 == $player_array[i].position_id)}
                                        <?php foreach ($gk_attribute_array as $attribute) { ?>
                                            <option
                                                value="{$gk_attribute_array[j].attribute_id}"
                                                {if ($player_array[i].player_training_attribute_id == $gk_attribute_array[j].attribute_id)}
                                                    selected
                                                <?php } ?>
                                            >
                                                {$gk_attribute_array[j].attribute_name}
                                            </option>
                                        <?php } ?>
                                    {else}
                                        <?php foreach ($attribute_array as $attribute) { ?>
                                            <option
                                                value="{$attribute_array[j].attribute_id}"
                                                {if ($player_array[i].player_training_attribute_id == $attribute_array[j].attribute_id)}
                                                    selected
                                                <?php } ?>
                                            >
                                                {$attribute_array[j].attribute_name}
                                            </option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="center nopadding">
                                <select class="w100" name="data[{$player_array[i].player_id}][intensity]">
                                    <option
                                        value="1"
                                        {if (1 == $player_array[i].player_training_intensity)}
                                            selected
                                        <?php } ?>
                                    >
                                        Низкая
                                    </option>
                                    <option
                                        value="2"
                                        {if (2 == $player_array[i].player_training_intensity)}
                                            selected
                                        <?php } ?>
                                    >
                                        Средняя
                                    </option>
                                    <option
                                        value="3"
                                        {if (3 == $player_array[i].player_training_intensity)}
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