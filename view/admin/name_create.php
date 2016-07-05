<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование имени</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="name_list.php" class="btn btn-default">
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
                        <td>Страна</td>
                        <td>
                            <select class="form-control" name="country_id">
                                <?php foreach ($country_array as $item) { ?>
                                    <option value="<?= $item['country_id']; ?>"
                                        <?php if (isset($name_array[0]['countryname_country_id']) && $name_array[0]['countryname_country_id'] == $item['country_id']) { ?>
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
                        <td>Имя (через запятую)</td>
                        <td>
                            <textarea
                                class="form-control"
                                name="name_name"
                                rows="5"
                            ><?php if (isset($name_array[0]['name_name'])) { print $name_array[0]['name_name']; } ?></textarea>
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