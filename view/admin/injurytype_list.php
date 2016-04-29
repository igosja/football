<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Типы травм</h1>
        <button type="button" class="btn btn-default">
            <a href="injurytype_create.php">
                <i class="fa fa-plus"></i>
            </a>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed" id="bootstrap-table">
                <thead>
                    <tr>
                        <th>Тип</th>
                        <th>Длительность</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($injurytype_array as $item) { ?>
                        <tr>
                            <td><?= $item['injurytype_name']; ?></td>
                            <td><?= $item['injurytype_day']; ?></td>
                            <td>
                                <a href="injurytype_edit.php?num=<?= $item['injurytype_id']; ?>">
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