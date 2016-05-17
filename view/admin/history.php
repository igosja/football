<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">История действий</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Событие</th>
                        <th>Пользователь</th>
                        <th>Страна</th>
                        <th>Команда</th>
                        <th>Игрок</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history_array as $item) { ?>
                        <tr>
                            <td><?= f_igosja_ufu_date_time($item['history_date']); ?></td>
                            <td><?= $item['historytext_name']; ?></td>
                            <td><?= $item['user_login']; ?></td>
                            <td><?= $item['country_name']; ?></td>
                            <td><?= $item['team_name']; ?></td>
                            <td><?= $item['name_name']; ?> <?= $item['surname_name']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <nav class="text-center">
            <ul class="pagination">
                <?php for ($i=$start_pagination; $i<$end_pagination; $i++) { ?>
                    <li <?php if ($page == $i) { ?>class="active"<?php } ?>><a href="?page=<?=$i?>"><?=$i+1?></a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>