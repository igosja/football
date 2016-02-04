<table class="block-table w100">
    <tr>
        <td class="block-page w30">
            <p class="header">Сообщения</p>
            <p class="center"><button id="outbox-create">Написать</button></p>
            <div class="overflow">
                <table class="striped w100">
                    <?php foreach ($inbox_array as $item) { ?>
                        <tr>
                            <td class="outbox-title <?php if (0 == $item['inbox_read']) { ?>strong<?php } ?>" data-id="<?php print $item['inbox_id']; ?>">
                                <?php print $item['inbox_title']; ?>
                                <p class="grey"><?php print f_igosja_ufu_date($item['inbox_date']); ?> (<?php print $item['user_login']; ?>)</p>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </td>
        <td class="block-page" id="inbox-block">
            <p class="header inbox-header"></p>
            <table class="w100">
                <tr>
                    <td class="inbox-text"></td>
                </tr>
                <tr>
                    <td><?php print SPACE; ?></td>
                </tr>
                <tr>
                    <td class="inbox-button center"></td>
                </tr>
            </table>
            <form method="POST">
                <table id="outbox-form"  <?php if (0 == $answer) { ?>style="display:none;"<?php } ?> class="w100">
                    <tr>
                        <td>
                            <select id="autocomplete" name="data[inbox_user_id]">
                                <option value="-1">Тех. поддержка</option>
                                <?php foreach ($user_array as $item) { ?>
                                    <option value="<?php print $item['user_id']; ?>"
                                        <?php if ($answer == $item['user_id']) { ?>
                                            selected
                                        <?php } ?>
                                    ><?php print $item['user_login']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="w98" name="data[inbox_title]" placeholder="Тема сообщения" type="text" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea class="w98" name="data[inbox_text]" placeholder="Текст сообщения"  rows="10" required></textarea>
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