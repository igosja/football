<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Персонал</p>
            <table class="striped w100">
                <tr>
                    <th>Имя</th>
                    <th class="w1">Нац</th>
                    <th class="w20">Должность</th>
                    <th class="w10">Репутация</th>
                    <th class="w10">Зарплата</th>
                </tr>
                <?php foreach ($staff_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="staff_home_profile.php?num=<?= $item['staff_id']; ?>">
                                <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="w1">
                            <a href="national_team_review_profile.php?num=<?= $item['country_id']; ?>">
                                <img
                                    alt="<?= $item['country_name']; ?>"
                                    class="img-12"
                                    src="img/flag/12/<?= $item['country_id']; ?>.png"
                                    title="<?= $item['country_name']; ?>"
                                />
                            </a>
                        </td>
                        <td><?= $item['staffpost_name']; ?></td>
                        <td class="center"><?= f_igosja_five_star($item['staff_reputation'], 12); ?></td>
                        <td class="right"><?= f_igosja_money($item['staff_salary']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>