<table class="block-table w100">
    <tr>
        <td class="block-page">
            <?php if (0 == $num_get) { ?>
                <p class="header">Правила</p>
                <table class="bordered w100">
                    <?php foreach ($rule_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="rule.php?num=<?= $item['rule_id']; ?>"><?= $item['rule_name']; ?></a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p class="header"><?= $rule_array[0]['rule_name']; ?></p>
                <table class="bordered w100">
                    <tr>
                        <td>
                            <?= $rule_array[0]['rule_text']; ?>
                            <p class="center">
                                <button>
                                    <a href="rule.php">Назад</a>
                                </button>
                            </p>
                        </td>
                    </tr>
                </table>
            <?php } ?>
        </td>
    </tr>
</table>