<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Просмотр голосования</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="vote_list.php" class="btn btn-default">
                    <i class="fa fa-list"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>
                        <?= f_igosja_ufu_date_time($vote_array[0]['vote_date']); ?>,
                        <a href="user.php?num=<?= $vote_array[0]['user_id']; ?>">
                            <?= $vote_array[0]['user_login']; ?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= $vote_array[0]['vote_question']; ?>
                    </td>
                </tr>
                <?php foreach ($vote_array as $item) { ?>
                    <tr>
                        <td>
                            <?= $item['voteanswer_answer']; ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td class="text-center">
                        <?php if (0 == $vote_array[0]['vote_view']) { ?>
                            <a class="btn btn-default" href="vote_edit.php?num=<?= $num_get; ?>&ok=1">
                                Одобрить
                            </a>
                        <?php } ?>
                        <a class="btn btn-default" href="vote_edit.php?num=<?= $num_get; ?>&del=1">
                            Удалить
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>