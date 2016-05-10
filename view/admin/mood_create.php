<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование настроения</h1>
        <button type="button" class="btn btn-default">
            <a href="mood_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
    </div>
</div>
<form method="POST" enctype="multipart/form-data">
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>Настроение</td>
                    <td>
                        <input
                            class="form-control"
                            name="mood_name"
                            type="text"
                            value="<?php if (isset($mood_array[0]['mood_name'])) { print $mood_array[0]['mood_name']; } ?>"
                        />
                    </td>
                </tr>
                    <tr>
                        <td>Эмблема (15x15, png)</td>
                        <td>
                            <input
                                class="form-control"
                                name="mood_logo"
                                type="file"
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