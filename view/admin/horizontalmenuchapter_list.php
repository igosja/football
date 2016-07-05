<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Разделы сайта</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="horizontalmenuchapter_create.php" class="btn btn-default">
                    <i class="fa fa-plus"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                <tr>
                    <th>Раздел</th>
                    <th class="col-lg-1"></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($horizontalmenuchapter_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="horizontalmenuchapter.php?num=<?= $item['horizontalmenuchapter_id']; ?>">
                                    <?= $item['horizontalmenuchapter_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="horizontalmenuchapter_edit.php?num=<?= $item['horizontalmenuchapter_id']; ?>">
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