<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Пресса</p>
            <?php if (isset($authorization_user_id)) { ?>
                <table class="bordered center w100">
                    <tr>
                        <td>
                            <a href="press_add.php" class="button-link">
                                <button>
                                    Добавить новую статью
                                </button>
                            </a>
                        </td>
                    </tr>
                </table>
            <?php } ?>
            <table class="striped w100">
                <tr>
                    <th class="w15">Дата</th>
                    <th>Статья</th>
                    <th class="w15">Автор</th>
                </tr>
                <?php foreach ($press_array as $item) { ?>
                    <tr>
                        <td class="center"><?= f_igosja_ufu_date_time($item['press_date']); ?></td>
                        <td>
                            <a href="press.php?num=<?= $item['press_id']; ?>">
                                <?= $item['press_name']; ?>
                            </a>
                        </td>
                        <td class="center">
                            <a href="manager_home_profile.php?num=<?= $item['user_id']; ?>">
                                <?= $item['user_login']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>