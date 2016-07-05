<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Фамилии игроков</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="surname_create.php" class="btn btn-default">
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
                        <th>Фамилия</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($surname_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="surname.php?num=<?= $item['surname_id']; ?>">
                                    <?= $item['surname_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="surname_edit.php?num=<?= $item['surname_id']; ?>">
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