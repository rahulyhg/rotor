<?php
App::view($config['themes'].'/index');

$act = (isset($_GET['act'])) ? check($_GET['act']) : 'index';
$start = (isset($_GET['start'])) ? abs(intval($_GET['start'])) : 0;
$uz = (empty($_GET['uz'])) ? check($log) : check($_GET['uz']);

show_title('Блоги');
$config['newtitle'] = 'Блоги - Список разделов';



    $queryblog = DB::run() -> query("SELECT *, (SELECT COUNT(*) FROM `blogs` WHERE `blogs`.`cats_id` = `catsblog`.`id` AND `blogs`.`time` > ?) AS `new` FROM `catsblog` ORDER BY `order` ASC;", array(SITETIME-86400 * 3));

    $blogs = $queryblog -> fetchAll();

    if (count($blogs) > 0) {

        render('blog/index', array('blogs' => $blogs));

    } else {
        show_error('Разделы блогов еще не созданы!');
    }

App::view($config['themes'].'/foot');
