<table class="block-table w100">
    <tr>
        <td class="block-page" id="inbox-block">
            <p class="header inbox-header">Обращение в техподдержку</p>
            <table class="w100">
                <tr>
                    <td class="inbox-text">
                        <table class="striped w100">
                            <?php foreach ($inbox_array as $item) { ?>
                                <tr>
                                    <td
                                        class="
                                        <?php if ($authorization_user_id == $item['inbox_user_id']) { ?>right<?php } ?>
                                        <?php if (0 == $item['inbox_read']) { ?>strong<?php } ?>
                                        "
                                    >
                                        <span class="grey"><?= f_igosja_ufu_date_time($item['inbox_date']); ?></span>
                                        <br />
                                        <?= nl2br($item['inbox_text']); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><?= SPACE; ?></td>
                </tr>
                <tr>
                    <td class="inbox-button center"></td>
                </tr>
            </table>
            <form method="POST">
                <table id="outbox-form" class="w100">
                    <tr>
                        <td>
                            <textarea class="w98" name="data[inbox_text]" placeholder="Текст сообщения" rows="10" required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="center">
                            <input type="submit" value="Отправить">
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>