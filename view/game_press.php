<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Комментарии к матчу</p>
            <table class="striped w100">
                <?php foreach ($gamecomment_array as $item) { ?>
                <tr>
                    <td>
                        <p class="grey">
                            <?= f_igosja_ufu_date_time($item['gamecomment_date']); ?>,
                            <a href="manager_home_profile.php?num=<?= $item['user_id']; ?>">
                                <?= $item['user_login']; ?>
                            </a>
                        </p>
                        <?= nl2br($item['gamecomment_text']); ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <?php if (isset($authorization_user_id)) { ?>
                <form method="POST">
                    <table class="bordered w100">
                        <tr>
                            <th>
                                Оставьте свой комментарий:
                            </th>
                        </tr>
                        <tr>
                            <td class="center">
                                <textarea name="gamecomment_text" class="w98" rows="5" placeholder="Ваш комментарий"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="center">
                                <input type="submit" value="Сохранить комментарий" />
                            </td>
                        </tr>
                    </table>
                </form>
            <?php } ?>
        </td>
    </tr>
</table>