<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Расстановки команд</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="formation_create.php" class="btn btn-default">
                    <i class="fa fa-list"></i>
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
                        <th>Расстановка</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($formation_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="formation.php?num=<?= $item['formation_id']; ?>">
                                    <?= $item['formation_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="formation_edit.php?num=<?= $item['formation_id']; ?>">
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