@extends('layout')

@section('title')
    Просмотр истории {{ $user->login }}
@stop

@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/admin">{{ trans('index.panel') }}</a></li>
            <li class="breadcrumb-item"><a href="/admin/banhists">История банов</a></li>
            <li class="breadcrumb-item active">Просмотр истории {{ $user->login }}</li>
        </ol>
    </nav>
@stop

@section('content')
    @if ($banhist->isNotEmpty())

        <form action="/admin/banhists/delete?user={{ $user->login }}&amp;page={{ $page->current }}" method="post">
            @csrf
            @foreach ($banhist as $data)
                <div class="b">

                    <div class="float-right">
                        <input type="checkbox" name="del[]" value="{{ $data->id }}">
                    </div>

                    <div class="img">
                        {!! $data->user->getAvatar() !!}
                        {!! $data->user->getOnline() !!}
                    </div>

                    <b>{!! $data->user->getProfile() !!}</b> ({{ dateFixed($data->created_at) }})
                </div>

                <div>
                    @if ($data->type !== 'unban')
                        Причина: {!! bbCode($data->reason) !!}<br>
                        Срок: {{ formatTime($data->term) }}<br>
                    @endif

                    {!! $data->getType() !!}: {!! $data->sendUser->getProfile() !!}<br>

                </div>
            @endforeach

            <div class="float-right">
                <button class="btn btn-sm btn-danger">Удалить выбранное</button>
            </div>
        </form>

        {!! pagination($page) !!}

    @else
        {!! showError('В истории еще ничего нет!') !!}
    @endif
@stop
