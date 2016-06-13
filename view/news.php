<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Новости</p>
            <table class="w100">
                <tr>
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
                        </form>
                    </td>
                </tr>
            </table>
            <table class="striped w100">
                <tr>
                    <th class="w15">Дата</th>
                    <th>Новость</th>
                    <th class="w15">Комментарии</th>
                </tr>
                <?php foreach ($news_array as $item) { ?>
                    <tr>
                        <td class="center"><?= f_igosja_ufu_date_time($item['news_date']); ?></td>
                        <td>
                            <strong><?= $item['news_title']; ?></strong>
                            <br />
                            <?= nl2br($item['news_text']); ?>
                            <br />
                            <a href="manager_home_profile.php?num=1" class="red">
                                Игося
                            </a>
                        </a>
                        </td>
                        <td class="center">
                            <a href="newscomment.php?num=<?= $item['news_id']; ?>">
                                <?php if ($item['newscomment_count']) { ?><?= $item['newscomment_count']; ?> коммент.<?php } else { ?>Комментировать<?php } ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>