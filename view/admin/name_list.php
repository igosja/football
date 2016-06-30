<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Имена игроков</h1>
        <button type="button" class="btn btn-default">
            <a href="name_create.php">
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
                    <th>Имя</th>
                    <th class="col-lg-1"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($name_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="name.php?num=<?= $item['name_id']; ?>">
                                <?= $item['name_name']; ?>
                            </a>
                        </td>
                        <td>
                            <a href="name_edit.php?num=<?= $item['name_id']; ?>">
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