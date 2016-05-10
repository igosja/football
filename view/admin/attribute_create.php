<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование характеристики</h1>
        <button type="button" class="btn btn-default">
            <a href="attribute_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
    </div>
</div>
<form method="POST">
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>Страница</td>
                    <td>
                        <input
                            class="form-control"
                            name="attribute_name"
                            type="text"
                            value="<?php if (isset($attribute_array[0]['attribute_name'])) { print $attribute_array[0]['attribute_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Группа</td>
                    <td>
                        <select class="form-control" name="chapter_id">
                            <?php foreach ($chapter_array as $item) { ?>
                                <option value="<?= $item['attributechapter_id']; ?>"
                                    <?php if (isset($attribute_array[0]['attribute_attributechapter_id']) && $attribute_array[0]['attribute_attributechapter_id'] == $item['attributechapter_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['attributechapter_name']; ?>
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