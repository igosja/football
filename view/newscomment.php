<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Комментирование новости</p>
            <table class="striped w100">
                <tr>
                    <th class="w15">Дата</th>
                    <th>Новость</th>
                </tr>
                <tr>
                    <td class="center"><?= f_igosja_ufu_date_time($news_array[0]['news_date']); ?></td>
                    <td>
                        <strong><?= $news_array[0]['news_title']; ?></strong>
                        <br />
                        <?= nl2br($news_array[0]['news_text']); ?>
                        <br />
                        <a href="manager_home_profile.php?num=1" class="red">
                            Игося
                        </a>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <?php foreach ($newscomment_array as $item) { ?>
                <tr>
                    <td>
                        <?= f_igosja_ufu_date_time($item['newscomment_date']); ?>,
                        <a href="manager_home_profile.php?num=<?= $item['user_id']; ?>">
                            <?= $item['user_login']; ?>
                        </a>
                        <br />
                        <?= nl2br($item['newscomment_text']); ?>
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
                                <textarea name="newscomment_text" class="w98" rows="5" placeholder="Ваш комментарий"></textarea>
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