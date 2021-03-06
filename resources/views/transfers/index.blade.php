@extends('layout')

@section('title')
    {{ trans('transfers.title') }}
@stop

@section('breadcrumb')
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/menu">{{ trans('main.menu') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('transfers.title') }}</li>
        </ol>
    </nav>
@stop

@section('content')
    {{ trans('transfers.in_stock') }}: {{ plural(getUser('money'), setting('moneyname')) }}<br><br>

    @if (getUser('point') >= setting('sendmoneypoint'))
        <div class="form">
            <form action="/transfers/send" method="post">
                @csrf
                @if ($user)
                    <i class="fa fa-money-bill-alt"></i> {{ trans('transfers.transfer_for') }} <b>{{ $user->login }}</b>:<br><br>
                    <input type="hidden" name="user" value="{{ $user->login }}">
                @else
                    <div class="form-group{{ hasError('user') }}">
                        <label for="inputUser">{{ trans('main.user_login') }}:</label>
                        <input name="user" class="form-control" id="inputUser" maxlength="20" placeholder="{{ trans('main.user_login') }}" value="{{ getInput('user') }}" required>
                        <div class="invalid-feedback">{{ textError('user') }}</div>
                    </div>
                @endif

                <div class="form-group{{ hasError('money') }}">
                    <label for="inputMoney">{{ trans('transfers.sum') }}:</label>
                    <input name="money" class="form-control" id="inputMoney" placeholder="{{ trans('transfers.sum') }}" value="{{ getInput('money') }}" required>
                    <div class="invalid-feedback">{{ textError('money') }}</div>
                </div>

                <div class="form-group{{ hasError('msg') }}">
                    <label for="msg">{{ trans('transfers.comment') }}:</label>
                    <textarea class="form-control markItUp" maxlength="{{ setting('comment_length') }}" id="msg" rows="5" name="msg" placeholder="{{ trans('transfers.comment') }}">{{ getInput('msg') }}</textarea>
                    <div class="invalid-feedback">{{ textError('msg') }}</div>
                    <span class="js-textarea-counter"></span>
                </div>

                <button class="btn btn-primary">{{ trans('transfers.transfer') }}</button>
            </form>
        </div><br>
    @else
       {!! showError(trans('transfers.error', ['points' => plural(setting('sendmoneypoint'), setting('scorename'))])) !!}
    @endif

@stop
