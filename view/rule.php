<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Правила</p>
            <table class="bordered w100">
                <?php foreach ($rule_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="javascript:;" class="bordered rule" data-id="<?= $item['rule_id']; ?>"><?= $item['rule_name']; ?></a>
                        </td>
                    </tr>
                    <tr style="display: none;" id="rule-<?= $item['rule_id']; ?>" class="rule-text">
                        <td><?= $item['rule_text']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>