@extends('layout')

@section('title')
    {{ trans('offers.adding_record') }}
@stop

@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/offers/offer">{{ trans('offers.title') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('offers.adding_record') }}</li>
        </ol>
    </nav>
@stop

@section('content')
    @if (getUser('point') >= setting('addofferspoint'))
        <div class="form">
            <form action="/offers/create" method="post">
                @csrf
                <?php $inputType = getInput('type', $type); ?>
                <div class="form-group{{ hasError('type') }}">
                    <label for="inputType">{{ trans('offers.i_want_to') }}</label>
                    <select class="form-control" id="inputType" name="type">
                        <option value="offer"{{ $inputType === 'offer' ? ' selected' : '' }}>{{ trans('offers.suggest_idea') }}</option>
                        <option value="issue"{{ $inputType === 'issue' ? ' selected' : '' }}>{{ trans('offers.report_problem') }}</option>
                    </select>
                    <div class="invalid-feedback">{{ textError('type') }}</div>
                </div>

                <div class="form-group{{ hasError('title') }}">
                    <label for="inputTitle">{{ trans('offers.name') }}:</label>
                    <input type="text" class="form-control" id="inputTitle" name="title" maxlength="50" value="{{ getInput('title') }}" required>
                    <div class="invalid-feedback">{{ textError('title') }}</div>
                </div>

                <div class="form-group{{ hasError('text') }}">
                    <label for="text">{{ trans('offers.text') }}:</label>
                    <textarea class="form-control markItUp" id="text" rows="5" name="text" required>{{ getInput('text') }}</textarea>
                    <div class="invalid-feedback">{{ textError('text') }}</div>
                </div>

                <button class="btn btn-primary">{{ trans('offers.add_offer') }}</button>
            </form>
        </div><br>

    @else
        {!! showError(trans('offers.condition_add', ['point' => plural(setting('addofferspoint'), setting('scorename'))])) !!}
    @endif
@stop
