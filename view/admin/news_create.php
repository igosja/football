<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование новости</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="news_list.php" class="btn btn-default">
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
                    <td>Заголовок</td>
                    <td>
                        <input
                            class="form-control"
                            name="news_title"
                            type="text"
                            value="<?php if (isset($news_array[0]['news_title'])) { print $news_array[0]['news_title']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Текст</td>
                    <td>
                        <textarea
                            class="form-control"
                            name="news_text"
                            rows="10"
                        ><?php if (isset($news_array[0]['news_text'])) { print $news_array[0]['news_text']; } ?></textarea>
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