<?php
App::view($config['themes'].'/index');

$uz = empty($_GET['uz']) ? check($log) : check($_GET['uz']);
$act = isset($_GET['act']) ? check($_GET['act']) : 'files';
$start = isset($_GET['start']) ? abs(intval($_GET['start'])) : 0;

switch ($act):
############################################################################################
##                                      Вывод файлов                                      ##
############################################################################################
case 'files':
    show_title('Список всех файлов');

    echo '<i class="fa fa-book"></i> ';
    echo '<a href="/load/add">Публикация</a> / ';
    echo '<a href="/load/add?act=waiting">Ожидающие</a> / ';
    echo '<b>Проверенные</b><hr />';

    $total = DB::run() -> querySingle("SELECT count(*) FROM `downs` WHERE `active`=? AND `user`=?;", [1, $uz]);

    if ($total > 0) {
        if ($start >= $total) {
            $start = 0;
        }

        $querydown = DB::run() -> query("SELECT `d`.*, `name`, folder FROM `downs` d LEFT JOIN `cats` c ON `d`.`category_id`=`c`.`id` WHERE `active`=? AND `user`=? ORDER BY `time` DESC LIMIT ".$start.", ".$config['downlist'].";", [1, $uz]);

        while ($data = $querydown -> fetch()) {
            $folder = $data['folder'] ? $data['folder'].'/' : '';

            $filesize = (!empty($data['link'])) ? read_file(HOME.'/upload/files/'.$folder.$data['link']) : 0;

            echo '<div class="b"><i class="fa fa-file-o"></i> ';
            echo '<b><a href="/load/down?act=view&amp;id='.$data['id'].'">'.$data['title'].'</a></b> ('.$filesize.')</div>';

            echo '<div>Категория: <a href="/load/down?cid='.$data['id'].'">'.$data['name'].'</a><br />';
            echo 'Скачиваний: '.$data['loads'].'<br />';
            echo '<a href="/load/down?act=comments&amp;id='.$data['id'].'">Комментарии</a> ('.$data['comments'].') ';
            echo '<a href="/load/down?act=end&amp;id='.$data['id'].'">&raquo;</a></div>';
        }

        page_strnavigation('/load/active?act=files&amp;uz='.$uz.'&amp;', $config['downlist'], $start, $total);
    } else {
        show_error('Опубликованных файлов не найдено!');
    }
break;

############################################################################################
##                                     Вывод комментарий                                  ##
############################################################################################
case 'comments':
    show_title('Список всех комментариев');

    $total = DB::run() -> querySingle("SELECT count(*) FROM `comments` WHERE relate_type=? AND `user`=?;", ['down', $uz]);

    if ($total > 0) {
        if ($start >= $total) {
            $start = 0;
        }

        $is_admin = is_admin();

        $querypost = DB::run() -> query("SELECT `c`.*, `title`, `comments` FROM `comments` c LEFT JOIN `downs` d ON `c`.`relate_id`=`d`.`id` WHERE relate_type=? AND c.`user`=? ORDER BY c.`time` DESC LIMIT ".$start.", ".$config['downlist'].";", ['down', $uz]);

        while ($data = $querypost -> fetch()) {
            echo '<div class="b">';

            echo '<i class="fa fa-comment"></i> <b><a href="/load/active?act=viewcomm&amp;id='.$data['relate_id'].'&amp;cid='.$data['id'].'">'.$data['title'].'</a></b> ('.$data['comments'].')';

            if ($is_admin) {
                echo ' — <a href="/load/active?act=del&amp;id='.$data['id'].'&amp;uz='.$uz.'&amp;start='.$start.'&amp;uid='.$_SESSION['token'].'">Удалить</a>';
            }

            echo '</div>';
            echo '<div>'.App::bbCode($data['text']).'<br />';

            echo 'Написал: '.nickname($data['user']).' <small>('.date_fixed($data['time']).')</small><br />';

            if ($is_admin || empty($config['anonymity'])) {
                echo '<span class="data">('.$data['brow'].', '.$data['ip'].')</span>';
            }

            echo '</div>';
        }

        page_strnavigation('/load/active?act=comments&amp;uz='.$uz.'&amp;', $config['downlist'], $start, $total);
    } else {
        show_error('Комментарии не найдены!');
    }
break;

############################################################################################
##                                     Переход к сообщение                                ##
############################################################################################
case 'viewcomm':

    if (isset($_GET['id'])) {
        $id = abs(intval($_GET['id']));
    } else {
        $id = 0;
    }
    if (isset($_GET['cid'])) {
        $cid = abs(intval($_GET['cid']));
    } else {
        $cid = 0;
    }

    $querycomm = DB::run() -> querySingle("SELECT COUNT(*) FROM `comments` WHERE relate_type=? AND `id`<=? AND `relate_id`=? ORDER BY `time` ASC LIMIT 1;", ['down', $cid, $id]);

    if (!empty($querycomm)) {
        $end = floor(($querycomm - 1) / $config['downlist']) * $config['downlist'];

        redirect("/load/down?act=comments&id=$id&start=$end");
    } else {
        show_error('Ошибка! Комментарий к данному файлу не существует!');
    }
break;

############################################################################################
##                                 Удаление комментариев                                  ##
############################################################################################
case 'del':

    $uid = check($_GET['uid']);
    if (isset($_GET['id'])) {
        $id = abs(intval($_GET['id']));
    } else {
        $id = 0;
    }

    if (is_admin()) {
        if ($uid == $_SESSION['token']) {
            $downs = DB::run() -> querySingle("SELECT `down` FROM `comments` WHERE relate_type=? AND `id`=?;", ['down', $id]);
            if (!empty($downs)) {
                DB::run() -> query("DELETE FROM `comments` WHERE relate_type=? AND `id`=? AND `relate_id`=?;", ['down', $id, $downs]);
                DB::run() -> query("UPDATE `downs` SET `comments`=`comments`-? WHERE `id`=?;", [1, $downs]);

                notice('Комментарий успешно удален!');
                redirect("/load/active?act=comments&uz=$uz&start=$start");
            } else {
                show_error('Ошибка! Данного комментария не существует!');
            }
        } else {
            show_error('Ошибка! Неверный идентификатор сессии, повторите действие!');
        }
    } else {
        show_error('Ошибка! Удалять комментарии могут только модераторы!');
    }

    echo '<i class="fa fa-arrow-circle-left"></i> <a href="/load/active?act=comments&amp;uz='.$uz.'&amp;start='.$start.'">Вернуться</a><br />';
break;

endswitch;

echo '<i class="fa fa-arrow-circle-up"></i> <a href="/load">Категории</a><br />';

App::view($config['themes'].'/foot');