@extends('layout')

@section('title')
    {{ $offer->title }}
@stop

@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/admin">{{ trans('index.panel') }}</a></li>
            <li class="breadcrumb-item"><a href="/admin/offers/{{ $offer->type }}">{{ trans('offers.title') }}</a></li>
            <li class="breadcrumb-item active">{{ $offer->title }}</li>
            <li class="breadcrumb-item"><a href="/offers/{{ $offer->id }}">{{ trans('main.review') }}</a></li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="b">
        <div class="float-right">
            <a href="/admin/offers/reply/{{ $offer->id }}" data-toggle="tooltip" title="{{ trans('main.reply') }}"><i class="fas fa-reply text-muted"></i></a>
            <a href="/admin/offers/edit/{{ $offer->id }}" data-toggle="tooltip" title="{{ trans('main.edit') }}"><i class="fas fa-pencil-alt text-muted"></i></a>
            <a href="/admin/offers/delete?del={{ $offer->id }}&amp;token={{ $_SESSION['token'] }}" onclick="return confirm('{{ trans('offers.confirm_delete') }}')" data-toggle="tooltip" title="{{ trans('main.delete') }}"><i class="fas fa-times text-muted"></i></a>
        </div>

        {!! $offer->getStatus() !!}
    </div>

    <div>
        {!! bbCode($offer->text) !!}<br><br>

        {{ trans('main.added') }}: {!! $offer->user->getProfile() !!} ({{ dateFixed($offer->created_at) }})<br>

        <div class="js-rating">{{ trans('main.rating') }}:
            <span>{!! formatNum($offer->rating) !!}</span><br>
        </div>

        <a href="/offers/comments/{{ $offer->id }}">{{ trans('main.comments') }}</a> ({{ $offer->count_comments }})
        <a href="/offers/end/{{ $offer->id }}">&raquo;</a><br>

        @if ($offer->closed)
            <span class="text-danger">{{ trans('offers.closed_comments') }}</span>
        @endif

    </div><br>

    @if ($offer->reply)
        <div class="b"><b>{{ trans('offers.official_response') }}</b></div>
        <div class="q">
            {!! bbCode($offer->reply) !!}<br>
            {!! $offer->replyUser->getProfile() !!} ({{ dateFixed($offer->updated_at) }})
        </div><br>
    @endif
@stop
