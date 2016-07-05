<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование темы сообщений</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="inboxtheme_list.php" class="btn btn-default">
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
                        <td>Тема</td>
                        <td>
                            <input 
                                class="form-control"
                                name="inboxtheme_name" 
                                type="text" 
                                value="<?php if (isset($inboxtheme_array[0]['inboxtheme_name'])) { print $inboxtheme_array[0]['inboxtheme_name']; } ?>"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td>Текст</td>
                        <td>
                            <textarea 
                                class="form-control"
                                name="inboxtheme_text" 
                                rows="5" 
                            ><?php if (isset($inboxtheme_array[0]['inboxtheme_text'])) { print $inboxtheme_array[0]['inboxtheme_text']; } ?></textarea>
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