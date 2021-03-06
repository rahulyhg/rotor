@extends('layout')

@section('title')
    {{ trans('forums.forum') }} - {{ trans('forums.title_new_topics') }} ({{ trans('main.page_num', ['page' => $page->current]) }})
@stop

@section('header')
    <h1>{{ trans('forums.title_new_topics') }}</h1>
@stop

@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/forums">{{ trans('forums.forum') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('forums.title_new_topics') }}</li>
        </ol>
    </nav>
@stop

@section('content')
    @foreach ($topics as $data)
        <div class="b">
            <i class="fa {{ $data->getIcon() }} text-muted"></i>
            <b><a href="/topics/{{ $data->id }}">{{ $data->title }}</a></b> ({{ $data->count_posts }})
        </div>

        <div>
            {!! $data->pagination() !!}
            {{ trans('forums.forum') }}: <a href="/forums/{{  $data->forum->id }}">{{  $data->forum->title }}</a><br>
            {{ trans('main.author') }}: {{ $data->user->getName() }} / Посл.: {{ $data->lastPost->user->getName() }} ({{ dateFixed($data->created_at) }})
        </div>

    @endforeach

    {!! pagination($page) !!}
@stop
