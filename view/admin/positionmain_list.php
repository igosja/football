<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование пола</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="gender_list.php" class="btn btn-default">
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
                    <th></th>
                    <th>Позиция</th>
                </tr>
                <?php foreach ($position_array as $item) { ?>
                    <tr>
                        <td>
                            <input
                                name="position_id[]"
                                type="checkbox"
                                value="<?= $item['position_id']; ?>"
                                <?php if (0 != $item['positionmain_id']) { ?>
                                    checked
                                <?php } ?>
                            />
                        </td>
                        <td>
                            <?= $item['position_description']; ?>
                        </td>
                    </tr>
                <?php } ?>
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