<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Опросы</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th class="col-lg-2">Дата</th>
                        <th class="col-lg-3">Автор</th>
                        <th>Вопрос</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vote_array as $item) { ?>
                        <tr>
                            <td><?= f_igosja_ufu_date_time($item['vote_date']); ?></td>
                            <td>
                                <a href="user.php?num=<?= $item['user_id']; ?>">
                                    <?= $item['user_login']; ?>
                                </a>
                            </td>
                            <td>
                                <?php if (0 == $item['vote_view']) { ?><i class="fa fa-check-square-o"></i><?php } ?>
                                <?= $item['vote_question']; ?>
                            </td>
                            <td>
                                <a href="vote_edit.php?num=<?= $item['vote_id']; ?>"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>