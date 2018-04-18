@extends('layout')

@section('title')
    {{ $path ?? 'Редактирование страниц' }}
@stop

@section('content')

    @if (getUser())
        <div class="float-right">
            <a class="btn btn-success" href="/admin/files/create?path={{ $path }}">Создать</a><br>
        </div><br>
    @endif

    <h1>{{ $path ?? 'Редактирование страниц' }}</h1>

    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/admin">Панель</a></li>

            @if ($path)
                <li class="breadcrumb-item"><a href="/admin/files">Редактирование страниц</a></li>

                <?php $dirName = []; ?>
                @foreach ($directories as $directory)
                    <?php $dirName[] = $directory; ?>
                    @if ($path !== implode('/', $dirName))
                        <li class="breadcrumb-item"><a href="/admin/files?path={{ implode('/', $dirName) }}">{{ implode('/', $dirName) }}</a></li>
                    @endif
                @endforeach
            @endif

            <li class="breadcrumb-item active">{{ $path ?? 'Редактирование страниц' }}</li>
        </ol>
    </nav>

    @if ($files)
        <ul class="list-group">
            @foreach ($files as $file)
                <?php $fileName = $path ? '/' . $file : $file; ?>
                @if (is_dir(RESOURCES . '/views/' . $path . $fileName))
                    <li class="list-group-item">
                        <div class="float-right">
                            <a href="/admin/files/delete?path={{ $path }}&amp;dirname={{ $file }}&amp;token={{ $_SESSION['token'] }}" onclick="return confirm('Вы действительно хотите удалить эту директорию')"><i class="fa fa-times"></i></a>
                        </div>

                        <i class="fa fa-folder"></i> <b><a href="/admin/files?path={{ $path . $fileName }}">{{ $file }}</a></b><br>
                        Объектов: {{ count(array_diff(scandir(RESOURCES . '/views/' . $path . $fileName), ['.', '..'])) }}
                    </li>
                @else
                    <?php $size = formatSize(filesize(RESOURCES . '/views/' . $path . $fileName)); ?>
                    <?php $string = count(file(RESOURCES . '/views/' . $path . $fileName)); ?>

                    <li class="list-group-item">
                        <div class="float-right">
                            <a href="/admin/files/delete?path={{ $path }}&amp;filename={{ basename($file, '.blade.php') }}&amp;token={{ $_SESSION['token'] }}" onclick="return confirm('Вы действительно хотите удалить этот файл')"><i class="fa fa-times"></i></a>
                        </div>

                        <i class="fa fa-file"></i>
                        <b><a href="/admin/files/edit?path={{ $path }}&amp;file={{ basename($file, '.blade.php') }}">{{ $file }}</a></b> ({{ $size }})<br>
                        Строк: {{ $string }} /
                        Изменен: {{ dateFixed(filemtime(RESOURCES . '/views/' . $path . $fileName)) }}
                    </li>
                @endif
            @endforeach
        </ul>
    @else
        {!! showError('Файлов нет!') !!}
    @endif
@stop
