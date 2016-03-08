<table class="block-table w100">
    <tr>
        <td class="block-page w33">
            <p class="header">Персональные данные</p>
            <table class="center w100">
                <tr>
                    <td>
                        <table class="striped w100">
                            <tr>
                                <td colspan="2">
                                    <h5><?php print $player_array[0]['position_description']; ?></h5>
                                </td>
                            </tr>
                            <tr>
                                <td class="w50">
                                    <a href="national_team_review_profile.php?num=<?php print $player_array[0]['country_id']; ?>">
                                        <img
                                            alt="<?php print $player_array[0]['country_name']; ?>"
                                            class="img-12"
                                            src="img/flag/12/<?php print $player_array[0]['country_id']; ?>.png"
                                        />
                                        <?php print $player_array[0]['country_name']; ?>
                                    </a>
                                    <br />
                                    Не вызывался
                                </td>
                                <td>
                                    <?php print $player_array[0]['player_age']; ?>
                                    <br />
                                    Возраст
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php print $player_array[0]['player_height']; ?> см
                                    <br />
                                    <?php print $player_array[0]['player_weight']; ?> кг
                                </td>
                                <td>
                                    <?php print f_igosja_leg_name($player_array[0]['player_leg_left'], $player_array[0]['player_leg_right']); ?>
                                    <br />
                                    Рабочая нога
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php print f_igosja_money($player_array[0]['player_salary']); ?> в день
                                    <br />
                                    Зарплата
                                </td>
                                <td>
                                    <?php print f_igosja_money($player_array[0]['player_price']); ?>
                                    <br />
                                    Стоимость
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Имеет сонтракт с клубом 
                                    <a href="team_team_review_profile.php?num=<?php print $player_array[0]['team_id']; ?>">
                                        <?php print $player_array[0]['team_name']; ?>
                                    </a>
                                </td>
                            </tr>
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
                                        <th colspan="2"><?php print $attribute_array[$i]['attributechapter_name']; ?></th>
                                    </tr>
                        <?php } ?>
                            <tr>
                                <td><?php print $attribute_array[$i]['attribute_name']; ?></td>
                                <td class="center w33">
                                    <?php if (isset($authorization_team_id) && $authorization_team_id == $player_array[0]['team_id']) { ?>
                                        <?php print $attribute_array[$i]['playerattribute_value']; ?>
                                        <a href="player_home_training.php?num=<?php print $num; ?>&char=<?php print $attribute_array[$i]['attribute_id']; ?>">+</a>
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