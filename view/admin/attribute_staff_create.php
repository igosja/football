<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование характеристики</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="attribute_staff_list.php" class="btn btn-default">
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
                    <td>Харатеристика</td>
                    <td>
                        <input
                            class="form-control"
                            name="attribute_name"
                            type="text"
                            value="<?php if (isset($attribute_array[0]['attributestaff_name'])) { print $attribute_array[0]['attributestaff_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Группа</td>
                    <td>
                        <select class="form-control" name="chapter_id">
                            <?php foreach ($chapter_array as $item) { ?>
                                <option value="<?= $item['attributechapterstaff_id']; ?>"
                                    <?php if (isset($attribute_array[0]['attributestaff_attributechapterstaff_id']) && $attribute_array[0]['attributestaff_attributechapterstaff_id'] == $item['attributechapterstaff_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['attributechapterstaff_name']; ?>
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