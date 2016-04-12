<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Поиск игрока</p>
            <table class="w100">
                <tr>
                    <td>
                        <form method="GET">
                            <input name="surname" placeholder="Фамилия" value="<?php if (isset($_GET['surname'])) { print $_GET['surname']; } ?>">
                            <select name="position">
                                <option value="0">Позиция</option>
                                <?php foreach ($position_array as $item) { ?>
                                    <option value="<?= $item['position_id']; ?>"
                                        <?php if (isset($_GET['position']) && $_GET['position'] == $item['position_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['position_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <select name="country">
                                <option value="0">Национальность</option>
                                <?php foreach ($country_array as $item) { ?>
                                    <option value="<?= $item['country_id']; ?>"
                                        <?php if (isset($_GET['country']) && $_GET['country'] == $item['country_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['country_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input name="age_min" size="1" placeholder="Возраст" value="<?php if (isset($_GET['age_min'])) { print $_GET['age_min']; } ?>">
                            -
                            <input name="age_max" size="1" placeholder="Возраст" value="<?php if (isset($_GET['age_max'])) { print $_GET['age_max']; } ?>">
                            <input name="weight_min" size="1" placeholder="Вес" value="<?php if (isset($_GET['weight_min'])) { print $_GET['weight_min']; } ?>">
                            -
                            <input name="weight_max" size="1" placeholder="Вес" value="<?php if (isset($_GET['weight_max'])) { print $_GET['weight_max']; } ?>">
                            <input name="height_min" size="1" placeholder="Рост" value="<?php if (isset($_GET['height_min'])) { print $_GET['height_min']; } ?>">
                            -
                            <input name="height_max" size="1" placeholder="Рост" value="<?php if (isset($_GET['height_max'])) { print $_GET['height_max']; } ?>">
                            <input name="price_min" size="6" placeholder="Цена ном." value="<?php if (isset($_GET['price_min'])) { print $_GET['price_min']; } ?>">
                            -
                            <input name="price_max" size="6" placeholder="Цена ном." value="<?php if (isset($_GET['price_max'])) { print $_GET['price_max']; } ?>">
                            <input name="transfer_price_min" size="6" placeholder="Цена трансф." value="<?php if (isset($_GET['transfer_price_min'])) { print $_GET['transfer_price_min']; } ?>">
                            -
                            <input name="transfer_price_max" size="6" placeholder="Цена трансф." value="<?php if (isset($_GET['transfer_price_max'])) { print $_GET['transfer_price_max']; } ?>">
                            <input type="hidden" name="num" value="<?php if (isset($_GET['num'])) { print $_GET['num']; } ?>" />
                            <input type="submit" value="Поиск">
                        </form>
                    </td>
                    <td class="right">
                        <form method="GET" id="page-form">
                            Старница:
                            <select name="page" id="page-select">
                                <?php for ($i=0; $i<$count_page; $i++) { ?>
                                    <option value="<?= $i + 1; ?>"
                                        <?php if (isset($_GET['page']) && $_GET['page'] == $i + 1) { ?>
                                            selected
                                        <?php } ?>
                                    ><?= $i + 1; ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="num" value="<?php if (isset($_GET['num'])) { print $_GET['num']; } ?>" />
                            <input type="hidden" name="surname" value="<?php if (isset($_GET['surname'])) { print $_GET['surname']; } ?>" />
                            <input type="hidden" name="position" value="<?php if (isset($_GET['position'])) { print $_GET['position']; } ?>" />
                            <input type="hidden" name="country" value="<?php if (isset($_GET['country'])) { print $_GET['country']; } ?>" />
                            <input type="hidden" name="age_min" value="<?php if (isset($_GET['age_min'])) { print $_GET['age_min']; } ?>" />
                            <input type="hidden" name="age_max" value="<?php if (isset($_GET['age_max'])) { print $_GET['age_max']; } ?>" />
                            <input type="hidden" name="weight_min" value="<?php if (isset($_GET['weight_min'])) { print $_GET['weight_min']; } ?>" />
                            <input type="hidden" name="weight_max" value="<?php if (isset($_GET['weight_max'])) { print $_GET['weight_max']; } ?>" />
                            <input type="hidden" name="height_min" value="<?php if (isset($_GET['height_min'])) { print $_GET['height_min']; } ?>" />
                            <input type="hidden" name="height_max" value="<?php if (isset($_GET['height_max'])) { print $_GET['height_max']; } ?>" />
                            <input type="hidden" name="price_min" value="<?php if (isset($_GET['price_min'])) { print $_GET['price_min']; } ?>" />
                            <input type="hidden" name="price_max" value="<?php if (isset($_GET['price_max'])) { print $_GET['price_max']; } ?>" />
                        </form>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th>Имя</th>
                    <th class="w1">Нац</th>
                    <th class="w5">Поз</th>
                    <th class="w5">Воз</th>
                    <th class="w5">Рост</th>
                    <th class="w5">Вес</th>
                    <th class="w10">Номинальная цена</th>
                    <th class="w10">Запрашиваемая цена</th>
                    <th colspan="2">Клуб</th>
                </tr>
                <?php foreach ($player_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="player_transfer_offer.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td>
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <img
                                    alt="<?= $item['country_name']; ?>"
                                    class="img-12"
                                    src="img/flag/12/<?= $item['country_id']; ?>.png"
                                    title="<?= $item['country_name']; ?>"
                                />
                            </a>
                        </td>
                        <td class="center"><?= $item['position_name']; ?></td>
                        <td class="center"><?= $item['player_age']; ?></td>
                        <td class="center"><?= $item['player_height']; ?> см</td>
                        <td class="center"><?= $item['player_weight']; ?> кг</td>
                        <td class="right"><?= f_igosja_money($item['player_price']); ?></td>
                        <td class="right"><?= f_igosja_money($item['player_transfer_price']); ?></td>
                        <td class="w1">
                            <img
                                alt="<?= $item['team_name']; ?>"
                                class="img-12"
                                src="img/team/12/<?= $item['team_id']; ?>.png"
                            />
                        </td>
                        <td class="w15">
                            <a href="team_team_review_profile.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>