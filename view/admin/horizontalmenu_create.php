<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование странцы</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="horizontalmenu_list.php" class="btn btn-default">
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
                        <td>Название</td>
                        <td>
                            <input
                                class="form-control"
                                name="menu_name"
                                type="text"
                                value="<?php if (isset($menu_array[0]['horizontalmenu_name'])) { print $menu_array[0]['horizontalmenu_name']; } ?>"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Раздел</td>
                        <td>
                            <select class="form-control" name="horizontalmenuchapter_id">
                                <?php foreach ($horizontalmenuchapter_array as $item) { ?>
                                    <option value="<?= $item['horizontalmenuchapter_id']; ?>"
                                        <?php if (isset($menu_array[0]['horizontalmenu_horizontalmenuchapter_id']) && $menu_array[0]['horizontalmenu_horizontalmenuchapter_id'] == $item['horizontalmenuchapter_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['horizontalmenuchapter_name']; ?>
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