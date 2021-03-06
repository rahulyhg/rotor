@extends('layout')

@section('title')
    Админ-чат
@stop

@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/admin">{{ trans('index.panel') }}</a></li>
            <li class="breadcrumb-item active">Админ-чат</li>
        </ol>
    </nav>
@stop

@section('content')
    <a href="/stickers">Стикеры</a> /
    <a href="/tags">Теги</a><hr>

    @if ($posts->isNotEmpty())

        @foreach ($posts as $post)
            <div class="post">
                <div class="b">
                    @if (getUser('id') !== $post->user_id)
                        <div class="float-right">
                            <a href="#" onclick="return postReply(this)" data-toggle="tooltip" title="Ответить"><i class="fa fa-reply text-muted"></i></a>
                            <a href="#" onclick="return postQuote(this)" data-toggle="tooltip" title="Цитировать"><i class="fa fa-quote-right text-muted"></i></a>
                        </div>
                    @endif

                    @if ($post->created_at + 600 > SITETIME && getUser('id') === $post->user_id)
                        <div class="float-right">
                            <a href="/admin/chats/edit/{{ $post->id }}?page={{ $page->current }}" title="Редактировать"><i class="fas fa-pencil-alt text-muted"></i></a>
                        </div>
                    @endif

                        <div class="img">
                            {!! $post->user->getAvatar() !!}
                            {!! $post->user->getOnline() !!}
                        </div>

                    <b>{!! $post->user->getProfile() !!}</b> <small>({{ dateFixed($post->created_at) }})</small><br>
                    {!! $post->user->getStatus() !!}
                </div>

                <div class="message">{!! bbCode($post->text) !!}</div>

                @if ($post->edit_user_id)
                    <small><i class="fa fa-exclamation-circle"></i> Отредактировано: {!! $post->editUser->getProfile() !!} ({{ dateFixed($post->updated_at) }})</small><br>
                @endif

                <span class="data">({{ $post->brow }}, {{ $post->ip }})</span>
            </div>
        @endforeach

        {!! pagination($page) !!}
    @else
        {!! showError('Сообщений нет, будь первым!') !!}
    @endif

    <div class="form">
        <form action="/admin/chats" method="post">
            @csrf
            <div class="form-group{{ hasError('msg') }}">
                <label for="msg">Сообщение:</label>
                <textarea class="form-control markItUp" id="msg" rows="5" name="msg" placeholder="Сообщение" required>{{ getInput('msg') }}</textarea>
                <div class="invalid-feedback">{{ textError('msg') }}</div>
            </div>

            <button class="btn btn-primary">Написать</button>
        </form>
    </div><br>

    @if ($page->total > 0 && isAdmin('boss'))
        <i class="fa fa-times"></i> <a href="/admin/chats/clear?token={{ $_SESSION['token'] }}" onclick="return confirm('Вы действительно хотите очистить админ-чат?')">Очистить чат</a><br>
    @endif
@stop
