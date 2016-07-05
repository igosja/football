<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование позиции</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="positioncreate_list.php" class="btn btn-default">
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
                    <td>Позиция</td>
                    <td>
                        <select class="form-control" name="position_id">
                            <?php foreach ($position_array as $item) { ?>
                                <option value="<?= $item['position_id']; ?>"
                                    <?php if (isset($position_id) && $position_id == $item['position_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['position_description']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <input class="btn btn-default" type="submit" value="Сохранить" />
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</form>