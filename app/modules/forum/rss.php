<?php

$tid  = isset($params['tid']) ? abs(intval($params['tid'])) : 0;

$topic = DB::run() -> queryFetch("SELECT * FROM `topics` WHERE `id`=? LIMIT 1;", array($tid));

if (empty($topic)) {
    App::abort('default', 'Данной темы не существует!');
}

$querypost = DB::run() -> query("SELECT * FROM `posts` WHERE `posts_topics_id`=? ORDER BY `posts_time` DESC LIMIT 15;", array($tid));
$posts = $querypost->fetchAll();

App::view('forum/rss', compact('topic', 'posts'));
