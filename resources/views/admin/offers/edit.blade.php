@extends('layout')

@section('title')
    {{ trans('offers.editing_record') }}
@stop

@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/admin">{{ trans('index.panel') }}</a></li>
            <li class="breadcrumb-item"><a href="/admin/offers/{{ $offer->type }}">{{ trans('offers.title') }}</a></li>
            <li class="breadcrumb-item"><a href="/admin/offers/{{ $offer->id }}">{{ $offer->title }}</a></li>
            <li class="breadcrumb-item active">{{ trans('offers.editing_record') }}</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="form">
        <form action="/admin/offers/edit/{{ $offer->id }}" method="post">
            @csrf
            <div class="form-group{{ hasError('type') }}">
                <label for="type">{{ trans('offers.i_want_to') }}</label>

                <?php $inputType = getInput('type', $offer->type); ?>
                <select class="form-control" name="type" id="type">
                    <option value="offer"{{ $inputType === 'offer' ? ' selected' : '' }}>{{ trans('offers.suggest_idea') }}</option>
                    <option value="issue"{{ $inputType === 'issue' ? ' selected' : '' }}>{{ trans('offers.report_problem') }}</option>
                </select>

                <div class="invalid-feedback">{{ textError('type') }}</div>
            </div>

            <div class="form-group{{ hasError('title') }}">
                <label for="inputTitle">{{ trans('offers.name') }}:</label>
                <input type="text" class="form-control" id="inputTitle" name="title" maxlength="50" value="{{ getInput('title', $offer->title) }}" required>
                <div class="invalid-feedback">{{ textError('title') }}</div>
            </div>

            <div class="form-group{{ hasError('text') }}">
                <label for="text">{{ trans('offers.text') }}:</label>
                <textarea class="form-control markItUp" id="text" rows="5" name="text" required>{{ getInput('text', $offer->text) }}</textarea>
                <div class="invalid-feedback">{{ textError('text') }}</div>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="hidden" value="0" name="closed">
                <input type="checkbox" class="custom-control-input" value="1" name="closed" id="closed"{{ getInput('closed', $offer->closed) ? ' checked' : '' }}>
                <label class="custom-control-label" for="closed">{{ trans('main.close_comments') }}</label>
            </div>

            <button class="btn btn-primary">{{ trans('offers.edit_offer') }}</button>
        </form>
    </div>
@stop
