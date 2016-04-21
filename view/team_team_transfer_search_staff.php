<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Поиск персонала</p>
            <?php if (isset($staff_id)) { ?>
                <p class="center info">
                    Вы собираетесь подписать контракт с <?= $name; ?> <?= $surname; ?>, <?= $post; ?><br />
                    <?= $post; ?>, с которым у вас есть текущий контракт, будет уволен.<br />
                    <a href="team_team_transfer_search_staff.php?num=<?= $num; ?>&staff_id=<?= $staff_id; ?>&ok=1">Подтверить</a> |
                    <a href="team_team_transfer_search_staff.php?num=<?= $num; ?>">Отказаться</a>
                </p>
            <?php } else { ?>
                <table class="w100">
                    <tr>
                        <td>
                            <form method="GET">
                                <input name="surname" placeholder="Фамилия" value="<?php if (isset($_GET['surname'])) { print $_GET['surname']; } ?>">
                                <select name="position">
                                    <option value="0">Должность</option>
                                    <?php foreach ($staffpost_array as $item) { ?>
                                        <option value="<?= $item['staffpost_id']; ?>"
                                            <?php if (isset($_GET['position']) && $_GET['position'] == $item['staffpost_id']) { ?>
                                                selected
                                            <?php } ?>
                                        >
                                            <?= $item['staffpost_name']; ?>
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
                        <th class="w1"></th>
                        <th>Имя</th>
                        <th colspan="2">Нац</th>
                        <th class="w15">Должность</th>
                        <th class="w10">Репутация</th>
                        <th class="w10">Зарплата</th>
                    </tr>
                    <?php foreach ($staff_array as $item) { ?>
                        <tr>
                            <td class="nopadding">
                                <a class="link-img link-ok" href="team_team_transfer_search_staff.php?num=<?= $num; ?>&staff_id=<?= $item['staff_id']; ?>&ok=0"></a>
                            </td>
                            <td>
                                <a href="staff_home_profile.php?num=<?= $item['staff_id']; ?>">
                                    <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                                </a>
                            </td>
                            <td class="w1">
                                <img
                                    alt="<?= $item['country_name']; ?>"
                                    class="img-12"
                                    src="/img/flag/12/<?= $item['country_id']; ?>.png"
                                />
                            </td>
                            <td class="w15">
                                <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                    <?= $item['country_name']; ?>
                                </a>
                            </td>
                            <td><?= $item['staffpost_name']; ?></td>
                            <td class="center"><?= f_igosja_five_star($item['staff_reputation'], 12); ?></td>
                            <td class="right"><?= f_igosja_money($item['staff_salary']); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>
        </td>
    </tr>
</table>