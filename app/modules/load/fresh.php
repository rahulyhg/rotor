<?php
App::view($config['themes'].'/index');

$start = isset($_GET['start']) ? abs(intval($_GET['start'])) : 0;

show_title('Список свежих загрузок');

$total = DB::run() -> querySingle("SELECT count(*) FROM `downs` WHERE `active`=? AND `time`>?;", array (1, SITETIME-3600 * 120));

if ($total > 0) {
    if ($start >= $total) {
        $start = 0;
    }

    $querydown = DB::run() -> query("SELECT `downs`.*, `name`, folder FROM `downs` LEFT JOIN `cats` ON `downs`.`cats_id`=`cats`.`id` WHERE `active`=? AND `time`>? ORDER BY `time` DESC LIMIT ".$start.", ".$config['downlist'].";", array(1, SITETIME-3600 * 120));

    while ($data = $querydown -> fetch()) {
        $folder = $data['folder'] ? $data['folder'].'/' : '';

        $filesize = (!empty($data['link'])) ? read_file(HOME.'/upload/files/'.$folder.$data['link']) : 0;

        echo '<div class="b">';

        if ($data['time'] >= (SITETIME-3600 * 24)) {
            echo '<i class="fa fa-file-o text-success"></i> ';
        } elseif ($data['time'] >= (SITETIME-3600 * 72)) {
            echo '<i class="fa fa-file-o text-warning"></i> ';
        } else {
            echo '<i class="fa fa-file-o text-danger"></i> ';
        }

        echo '<b><a href="/load/down?act=view&amp;id='.$data['id'].'">'.$data['title'].'</a></b> ('.$filesize.')</div>';

        echo '<div>Категория: <a href="/load/down?cid='.$data['cats_id'].'">'.$data['name'].'</a><br />';
        echo 'Скачиваний: '.$data['load'].'<br />';
        echo '<a href="/load/down?act=comments&amp;id='.$data['id'].'">Комментарии</a> ('.$data['comments'].') ';
        echo '<a href="/load/down?act=end&amp;id='.$data['id'].'">&raquo;</a><br />';
        echo 'Добавлено: '.profile($data['user']).' ('.date_fixed($data['time']).')</div>';
    }

    page_strnavigation('/load/fresh?', $config['downlist'], $start, $total);

    echo '<i class="fa fa-file-o text-success"></i> - Самая свежая загрузка<br />';
    echo '<i class="fa fa-file-o text-warning"></i> - Более дня назад<br />';
    echo '<i class="fa fa-file-o text-danger"></i> - Более 3 дней назад<br /><br />';

    echo 'Всего файлов: <b>'.$total.'</b><br /><br />';
} else {
    show_error('За последние 5 дней загрузок еще нет!');
}

echo '<i class="fa fa-arrow-circle-up"></i> <a href="/load">Категории</a><br />';

App::view($config['themes'].'/foot');
