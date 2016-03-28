<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Запросы к БД</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 text-center">
        <p>
            <button type="button" class="btn btn-default">Запросов: <?=$count_debug?></button>
            <button type="button" class="btn btn-default">Время: <?=round($time_array[0]['time']/1000)?> сек.</button>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th class="col-lg-1">Время, мс</th>
                        <th>Запрос</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($debug_array as $item) { ?>
                        <tr>
                            <td><?=$item['debug_time']?></td>
                            <td><?=$item['debug_sql']?></td>
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