@extends('layout')

@section('title')
    {{ trans('loads.title') }} - {{ trans('loads.active_downs', ['user' => $user->login]) }} ({{ trans('main.page_num', ['page' => $page->current]) }})
@stop

@section('header')
    <h1>{{ trans('loads.active_downs', ['user' => $user->login]) }}</h1>
@stop

@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/loads">{{ trans('loads.title') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('loads.active_downs', ['user' => $user->login]) }}</li>
        </ol>
    </nav>
@stop

@section('content')
    @if ($user->id === getUser('id'))
        <?php $type = ($active === 1) ? 'success' : 'light'; ?>
        <a href="/downs/active/files?active=1" class="badge badge-{{ $type }}">{{ trans('loads.verified') }}</a>

        <?php $type = ($active === 0) ? 'success' : 'light'; ?>
        <a href="/downs/active/files?active=0" class="badge badge-{{ $type }}">{{ trans('loads.pending') }}</a>
    @endif

    @if ($downs->isNotEmpty())
        @foreach ($downs as $down)
            <?php $rating = $down->rated ? round($down->rating / $down->rated, 1) : 0; ?>

            <div class="b">
                <i class="fa fa-file"></i>
                <b><a href="/downs/{{ $down->id }}">{{ $down->title }}</a></b> ({{ $down->count_comments }})
            </div>
            <div>
                {{ trans('loads.load') }}: <a href="/loads/{{ $down->category->id }}">{{ $down->category->name }}</a><br>
                {{ trans('main.rating') }}: {{ $rating }}<br>
                {{ trans('main.downloads') }}: {{ $down->loads }}<br>
                {{ trans('main.author') }}: {!! $down->user->getProfile() !!} ({{ dateFixed($down->created_at) }})
            </div>

        @endforeach

        {!! pagination($page) !!}
    @else
        {!! showError(trans('loads.empty_downs')) !!}
    @endif
@stop
