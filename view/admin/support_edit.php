<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Просмотр обращения в тех.поддержку</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="support_list.php" class="btn btn-default">
                    <i class="fa fa-list"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-12">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td <?php if (0 == $inbox_array[0]['user_id']) { ?>class="text-right info"<?php } else { ?>class="warning"<?php } ?>>
                        <td class="warning">
                            <?= f_igosja_ufu_date_time($inbox_array[0]['inbox_date']); ?>,
                            <?php if (0 == $inbox_array[0]['user_id']) { ?>
                                <span class="text-danger">Игося</span>
                            <?php } else { ?>
                                <a href="user.php?num=<?= $inbox_array[0]['user_id']; ?>">
                                    <?= $inbox_array[0]['user_login']; ?>
                                </a>
                            <?php } ?>
                            <br />
                            <?= nl2br($inbox_array[0]['inbox_text']); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea 
                                class="form-control"
                                name="inbox_text"
                                rows="5" 
                            ></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <input name="user_id" type="hidden" value="<?= $inbox_array[0]['inbox_sender_id']; ?>" />
                            <input class="btn btn-default" type="submit" value="Ответить" />
                        </td>
                    </tr>
                    <?php foreach (array_slice($inbox_array, 1) as $item) { ?>
                        <tr>
                            <td <?php if (0 == $item['user_id']) { ?>class="text-right info"<?php } else { ?>class="warning"<?php } ?>>
                                <?= f_igosja_ufu_date_time($item['inbox_date']); ?>,
                                <?php if (0 == $item['user_id']) { ?>
                                    <span class="text-danger">Игося</span>
                                <?php } else { ?>
                                    <a href="user.php?num=<?= $item['user_id']; ?>">
                                        <?= $item['user_login']; ?>
                                    </a>
                                <?php } ?>
                                <br />
                                <?= nl2br($item['inbox_text']); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</form>