<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Обращения в техподдержку</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Пользователь</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($support_array as $item) { ?>
                        <tr>
                            <td></i><?= f_igosja_ufu_date_time($item['inbox_date']); ?></td>
                            <td>
                                <?php if (0 == $item['inbox_read']) { ?><i class="fa fa-comment-o"><?php } ?>
                                <a href="user.php?num=<?= $item['user_id']; ?>">
                                    <?= $item['user_login']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="support_edit.php?num=<?= $item['inbox_id']; ?>"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>