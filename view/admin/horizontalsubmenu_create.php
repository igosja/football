<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование второй строки меню</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="horizontalsubmenu_list.php" class="btn btn-default">
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
                        <td>Страница</td>
                        <td>
                            <select
                                class="form-control"
                                id="select-ajax-give-1"
                                name="horizontalmenuchapter_id"
                                data-give="horizontalmenuchapter"
                                data-need="horizontalmenu"
                            >
                                <?php foreach ($horizontalmenuchapter_array as $item) { ?>
                                    <option value="<?= $item['horizontalmenuchapter_id']; ?>"
                                        <?php if (isset($page_id) && $page_id == $item['horizontalmenuchapter_id']) { ?>
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
                        <td>Родитель</td>
                        <td>
                            <select
                                class="form-control"
                                id="select-ajax-give-2"
                                name="menu_id"
                            >
                                <?php foreach ($horizontalmenu_array as $item) { ?>
                                    <option value="<?= $item['horizontalmenu_id']; ?>"
                                        <?php if (isset($menu_array[0]['horizontalsubmenu_horizontalmenu_id']) && $menu_array[0]['horizontalsubmenu_horizontalmenu_id'] == $item['horizontalmenu_id']) { ?>
                                            selected
                                        <?php } ?>
                                    >
                                        <?= $item['horizontalmenu_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Название</td>
                        <td>
                            <input
                                class="form-control"
                                name="menu_name"
                                type="text"
                                value="<?php if (isset($menu_array[0]['horizontalsubmenu_name'])) { print $menu_array[0]['horizontalsubmenu_name']; } ?>"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Ссылка</td>
                        <td>
                            <input
                                class="form-control"
                                name="menu_href"
                                type="text"
                                value="<?php if (isset($menu_array[0]['horizontalsubmenu_href'])) { print $menu_array[0]['horizontalsubmenu_href']; } ?>"
                            />
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