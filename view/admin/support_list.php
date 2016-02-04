<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Обращения в техподдержку</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="bootstrap-table">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Тема</th>
                        <th>Пользователь</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($support_array as $item) { ?>
                        <tr>
                            <td></i><?php print $item['inbox_date']; ?></td>
                            <td>
                                <?php if (0 == $item['inbox_read']) { ?><i class="fa fa-comment-o"><?php } ?>
                                <?php print $item['inbox_title']; ?>
                            </td>
                            <td><?php print $item['user_login']; ?></td>
                            <td>
                                <a href="support_edit.php?num=<?php print $item['inbox_id']; ?>"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>