<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование города</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="city_list.php" class="btn btn-default">
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
                    <td>Город</td>
                    <td>
                        <input
                            class="form-control"
                            name="city_name"
                            type="text"
                            value="<?php if (isset($city_array[0]['city_name'])) { print $city_array[0]['city_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Страна</td>
                    <td>
                        <select class="form-control" name="country_id">
                            <?php foreach ($country_array as $item) { ?>
                                <option value="<?= $item['country_id']; ?>"
                                    <?php if (isset($city_array[0]['city_country_id']) && $city_array[0]['city_country_id'] == $item['country_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['country_name']; ?>
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