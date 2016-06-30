<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Роли игроков</h1>
        <button type="button" class="btn btn-default">
            <a href="role_create.php">
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
                        <th>Роль</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($role_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="role.php?num=<?= $item['role_id']; ?>">
                                    <?= $item['role_short']; ?> - <?= $item['role_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="role_edit.php?num=<?= $item['role_id']; ?>">
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