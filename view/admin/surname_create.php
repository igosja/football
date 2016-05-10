<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование фамилии</h1>
        <button type="button" class="btn btn-default">
            <a href="surname_list.php">
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
                    <td>Страна</td>
                    <td>
                        <select class="form-control" name="country_id">
                            <?php foreach ($country_array as $item) { ?>
                                <option value="<?= $item['country_id']; ?>"
                                    <?php if (isset($surname_array[0]['countrysurname_country_id']) && $surname_array[0]['countrysurname_country_id'] == $item['country_id']) { ?>
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
                    <td>Фамилия</td>
                    <td>
                        <textarea
                            class="form-control"
                            name="surname_name"
                            rows="5"
                        ><?php if (isset($surname_array[0]['surname_name'])) { print $surname_array[0]['surname_name']; } ?></textarea>
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