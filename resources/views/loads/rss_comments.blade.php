@extends('layout_rss')

@section('title')
    {{ $down->title }}
@stop

@section('content')
    @foreach ($down->lastComments as $data)
        <?php $data->text = bbCode($data->text); ?>
        <?php $data->text = str_replace('/uploads/stickers', siteUrl().'/uploads/stickers', $data->text); ?>

        <item>
            <title>{{ $data->text }}</title>
            <link>{{ siteUrl() }}/down/comments/{{ $down->id }}</link>
            <description>{{ $down->title }}</description>
            <author>{{ $data->user->login }}</author>
            <pubDate>{{ date('r', $data->created_at) }}</pubDate>
            <category>{{ trans('main.comments') }}</category>
            <guid>{{ siteUrl() }}/down/comments/{{ $down->id }}?pid={{ $data->id }}</guid>
        </item>
    @endforeach
@stop

