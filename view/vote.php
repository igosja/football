<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Опрос</p>
            <?php if (0 == $vote_array[0]['vote_ready'] && isset($count_voteuser) && 0 == $count_voteuser) { ?>
                <form method="POST">
                    <table class="striped w100">
                        <tr>
                            <td class="w1"></td>
                            <td><strong><?= $vote_array[0]['vote_question']; ?></strong></td>
                            <td class="w10"></td>
                        </tr>
                        <?php foreach ($vote_array as $item) { ?>
                            <tr>
                                <td>
                                    <input type="radio" name="data" value="<?= $item['voteanswer_id']; ?>"/>
                                </td>
                                <td><?= $item['voteanswer_answer']; ?></td>
                                <td class="center"><?= $item['voteanswer_value']; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="center" colspan="3">
                                <input type="submit" value="Проголосовать">
                            </td>
                        </tr>
                    </table>
                </form>
            <?php } else { ?>
                <table class="striped w100">
                    <tr>
                        <td><strong><?= $vote_array[0]['vote_question']; ?></strong></td>
                        <td class="w10"></td>
                    </tr>
                    <?php foreach ($vote_array as $item) { ?>
                        <tr>
                            <td><?= $item['voteanswer_answer']; ?></td>
                            <td class="center"><?= $item['voteanswer_value']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>
        </td>
    </tr>
</table>