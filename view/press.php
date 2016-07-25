<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Просмотр статьи</p>
            <table class="striped w100">
                <tr>
                    <td class="center"><strong><?= $press_array[0]['press_name']; ?></strong></td>
                </tr>
                <tr>
                    <td class="center grey">
                        <a href="manager_home_profile.php?num=<?= $press_array[0]['user_id']; ?>">
                            <?= $press_array[0]['user_login']; ?>
                        </a>
                        в
                        <?= f_igosja_ufu_date_time($press_array[0]['press_date']); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="justify">
                            <?= nl2br($press_array[0]['press_text']); ?>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>