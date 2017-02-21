@extends('layout')

@section('title')
    Список новых тем - @parent
@stop

@section('content')
    <h1>Список новых тем</h1>

    <a href="/forum">Форум</a>

    <?php foreach ($topics as $data): ?>
        <div class="b">

            <?php
            if ($data['locked']) {
                $icon = 'fa-thumb-tack';
            } elseif ($data['closed']) {
                $icon = 'fa-lock';
            } else {
                $icon = 'fa-folder-open';
            }
            ?>

            <i class="fa <?=$icon?> text-muted"></i>
            <b><a href="/topic/<?=$data['id']?>"><?=$data['title']?></a></b> (<?=$data['posts']?>)
        </div>

        <div>
            <?= Forum::pagination($data)?>
            Форум: <a href="/forum/<?=$data['forum_id']?>"><?=$data['forum_title']?></a><br />
            Автор: <?=$data['author']?> / Посл.: <?=$data['last_user']?> (<?=date_fixed($data['last_time'])?>)
        </div>

    <?php endforeach; ?>

    <?php App::pagination($page) ?>
@stop
