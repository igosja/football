<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Новости</h1>
        <button type="button" class="btn btn-default">
            <a href="news_create.php">
                <i class="fa fa-plus"></i>
            </a>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Заголовок</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($news_array as $item) { ?>
                        <tr>
                            <td><?= f_igosja_ufu_date_time($item['news_date']); ?></td>
                            <td><?= $item['news_title']; ?></td>
                            <td>
                                <a href="news_edit.php?num=<?= $item['news_id']; ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>