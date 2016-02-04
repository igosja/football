<table class="block-table w100">
    <tr>
        <td class="block-page w30">
            <p class="header">Сообщения</p>
            <div class="overflow">
                <table class="striped w100">
                    <?php foreach ($inbox_array as $item) { ?>
                        <tr>
                            <td class="inbox-title <?php if (0 == $item['inbox_read']) { ?>strong<?php } ?>" data-id="<?php print $item['inbox_id']; ?>">
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
        </td>
    </tr>
</table>