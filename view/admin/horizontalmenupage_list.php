<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Страницы сайта</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="horizontalmenupage_create.php" class="btn btn-default">
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
                        <th>Страница</th>
                        <th>Раздел меню</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($horizontalmenupage_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="horizontalmenupage.php?num=<?= $item['horizontalmenupage_id']; ?>">
                                    <?= $item['horizontalmenupage_name']; ?>
                                </a>
                            </td>
                            <td><?= $item['horizontalmenuchapter_name']; ?></td>
                            <td>
                                <a href="horizontalmenupage_edit.php?num=<?= $item['horizontalmenupage_id']; ?>">
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