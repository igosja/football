<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Поиск персонала</p>
            <table class="w100">
                <tr>
                    <td class="left">
                        <form method="GET">
                            <input name="surname" placeholder="Фамилия" value="<?php if (isset($_GET['surname'])) { print $_GET['surname']; } ?>">
                            <select name="position">
                                <option value="0">Должность</option>
                                <?php foreach ($staffpost_array as $item) { ?>
                                    <option value="<?php print $item['staffpost_id']; ?>"
                                        <?php if (isset($_GET['position']) && $_GET['position'] == $item['staffpost_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?php print $item['staffpost_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <select name="country">
                                <option value="0">Национальность</option>
                                <?php foreach ($country_array as $item) { ?>
                                    <option value="<?php print $item['country_id']; ?>"
                                        <?php if (isset($_GET['country']) && $_GET['country'] == $item['country_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?php print $item['country_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="num" value="<?php if (isset($_GET['num'])) { print $_GET['num']; } ?>" />
                            <input type="submit" value="Поиск">
                        </form>
                    </td>
                    <td class="right">
                        <form method="GET" id="page-form">
                            Старница:
                            <select name="page" id="page-select">
                                <?php for ($i=0; $i<$count_page; $i++) { ?>
                                    <option value="<?php print $i + 1; ?>"
                                        <?php if (isset($_GET['page']) && $_GET['page'] == $i + 1) { ?>
                                            selected
                                        <?php } ?>
                                    ><?php print $i + 1; ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="surname" value="<?php if (isset($_GET['surname'])) { print $_GET['surname']; } ?>" />
                            <input type="hidden" name="position" value="<?php if (isset($_GET['position'])) { print $_GET['position']; } ?>" />
                            <input type="hidden" name="country" value="<?php if (isset($_GET['country'])) { print $_GET['country']; } ?>" />
                            <input type="hidden" name="num" value="<?php if (isset($_GET['num'])) { print $_GET['num']; } ?>" />
                        </form>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th>Имя</th>
                    <th colspan="2">Нац</th>
                    <th class="w15">Должность</th>
                    <th class="w10">Репутация</th>
                    <th class="w10">Зарплата</th>
                </tr>
                <?php foreach ($staff_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="staff_home_profile.php?num=<?php print $item['staff_id']; ?>">
                                <?php print $item['name_name']; ?> <?php print $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <img
                                alt="<?php print $item['country_name']; ?>"
                                class="img-12"
                                src="img/flag/12/<?php print $item['country_id']; ?>.png"
                            />
                        </td>
                        <td class="w15">
                            <a href="national_team_review_profile?num=<?php print $item['country_id']; ?>">
                                <?php print $item['country_name']; ?>
                            </a>
                        </td>
                        <td><?php print $item['staffpost_name']; ?></td>
                        <td class="center"><?php print f_igosja_five_star($item['staff_reputation'], 12); ?></td>
                        <td class="right"><?php print f_igosja_money($item['staff_salary']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>