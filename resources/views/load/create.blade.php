@extends('layout')

@section('title')
    Публикация нового файла
@stop

@section('content')

    <h1>Публикация нового файла</h1>

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/load">Загрузки</a></li>
            <li class="breadcrumb-item active">Публикация</li>
            {{--<li class="breadcrumb-item"><a href="/load/add?act=waiting">Ожидающие</a></li>--}}
            <li class="breadcrumb-item"><a href="/load/active">Проверенные</a></li>
        </ol>
    </nav>

    <form action="/down/create" method="post" enctype="multipart/form-data">
        <input type="hidden" name="token" value="{{ $_SESSION['token'] }}">

        <div class="form-group{{ hasError('category') }}">
            <label for="inputCategory">Категория</label>

            <select class="form-control" id="inputCategory" name="category">
                @foreach ($loads as $data)

                    <option value="{{ $data->id }}"{{ ($cid == $data->id && ! $data->closed) ? ' selected' : '' }}{{ $data->closed ? ' disabled' : '' }}>{{ $data->name }}</option>

                    @if ($data->children->isNotEmpty())
                        @foreach($data->children as $datasub)
                            <option value="{{ $datasub->id }}"{{ $cid == $datasub->id && ! $datasub->closed ? ' selected' : '' }}{{ $datasub->closed ? ' disabled' : '' }}>– {{ $datasub->name }}</option>
                        @endforeach
                    @endif
                @endforeach

            </select>
            {!! textError('category') !!}
        </div>

        <div class="form-group{{ hasError('title') }}">
            <label for="inputTitle">Название:</label>
            <input class="form-control" id="inputTitle" name="title" value="{{ getInput('title') }}" required>
            {!! textError('title') !!}
        </div>

        <div class="form-group{{ hasError('text') }}">
            <label for="text">Описание:</label>
            <textarea class="form-control markItUp" id="text" rows="10" name="text" required>{{ getInput('text') }}</textarea>
            {!! textError('text') !!}
        </div>

        Прикрепить файл ({{ setting('allowextload') }}):<br>
        <label class="btn btn-sm btn-secondary" for="file">
            <input id="file" type="file" name="file" onchange="$('#upload-file-info').html(this.files[0].name);" hidden>
            Прикрепить файл&hellip;
        </label>
        <span class="badge badge-info" id="upload-file-info"></span>
        {!! textError('file') !!}
        <br>

        Прикрепить скрин (jpg,jpeg,gif,png)<br>
        <label class="btn btn-sm btn-secondary" for="screen">
            <input id="screen" type="file" name="screen" onchange="$('#upload-screen-info').html(this.files[0].name);" hidden>
            Прикрепить картинку&hellip;
        </label>
        <span class="badge badge-info" id="upload-screen-info"></span>
        {!! textError('screen') !!}
        <br>

        <button class="btn btn-primary">Загрузить</button>
    </form>

    <div class="info">
        Максимальный вес файла: <b>{{ round(setting('fileupload') / 1024 / 1024) }}</b> Mb<br>
        Допустимые расширения файла: {{ str_replace(',', ', ', setting('allowextload')) }}<br>
        Допустимые расширения скриншотов: jpg,jpeg,gif,png
    </div><br>

    <div>
        Файл и скриншот вы сможете загрузить после добавления описания<br>
        Если вы ошиблись в названии или описании файла, вы всегда можете его отредактировать
    </div>
@stop
