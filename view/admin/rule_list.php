<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Правила</h1>
        <button type="button" class="btn btn-default">
            <a href="rule_create.php">
                <i class="fa fa-plus"></i>
            </a>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <form method="POST">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Правило</th>
                        <th class="col-lg-1">Порядок</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rule_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="rule.php?num=<?= $item['rule_id']; ?>">
                                    <?= $item['rule_name']; ?>
                                </a>
                            </td>
                            <td>
                                <input
                                    class="form-control"
                                    name="data[<?= $item['rule_id']; ?>]"
                                    type="text"
                                    value="<?= $item['rule_order']; ?>"
                                />
                            </td>
                            <td>
                                <a href="rule_edit.php?num=<?= $item['rule_id']; ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <p class="text-center">
            <input type="submit" value="Сохранить" class="btn btn-default">
        </p>
        </form>
    </div>
</div>