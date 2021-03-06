@section('header')
    <h1>Стоимость и цены</h1>
@stop

<form action="/admin/settings?act=price" method="post">
    @csrf
    <div class="form-group{{ hasError('sets[sendmoneypoint]') }}">
        <label for="sendmoneypoint">Актива для перечисления денег:</label>
        <input type="number" class="form-control" id="sendmoneypoint" name="sets[sendmoneypoint]" maxlength="4" value="{{ getInput('sets.sendmoneypoint', $settings['sendmoneypoint']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[sendmoneypoint]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[editratingpoint]') }}">
        <label for="editratingpoint">Актива для изменения репутации:</label>
        <input type="number" class="form-control" id="editratingpoint" name="sets[editratingpoint]" maxlength="4" value="{{ getInput('sets.editratingpoint', $settings['editratingpoint']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[editratingpoint]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[editforumpoint]') }}">
        <label for="editforumpoint">Актива для изменения тем форума:</label>
        <input type="number" class="form-control" id="editforumpoint" name="sets[editforumpoint]" maxlength="4" value="{{ getInput('sets.editforumpoint', $settings['editforumpoint']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[editforumpoint]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[advertpoint]') }}">
        <label for="advertpoint">Актива для скрытия рекламы:</label>
        <input type="number" class="form-control" id="advertpoint" name="sets[advertpoint]" maxlength="4" value="{{ getInput('sets.advertpoint', $settings['advertpoint']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[advertpoint]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[editstatuspoint]') }}">
        <label for="editstatuspoint">Актива для изменения статуса:</label>
        <input type="number" class="form-control" id="editstatuspoint" name="sets[editstatuspoint]" maxlength="4" value="{{ getInput('sets.editstatuspoint', $settings['editstatuspoint']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[editstatuspoint]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[editstatusmoney]') }}">
        <label for="editstatusmoney">Стоимость изменения статуса:</label>
        <input type="number" class="form-control" id="editstatusmoney" name="sets[editstatusmoney]" maxlength="10" value="{{ getInput('sets.editstatusmoney', $settings['editstatusmoney']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[editstatusmoney]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[bonusmoney]') }}">
        <label for="bonusmoney">Ежедневный бонус:</label>
        <input type="number" class="form-control" id="bonusmoney" name="sets[bonusmoney]" maxlength="10" value="{{ getInput('sets.bonusmoney', $settings['bonusmoney']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[bonusmoney]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[registermoney]') }}">
        <label for="registermoney">Денег за регистрацию:</label>
        <input type="number" class="form-control" id="registermoney" name="sets[registermoney]" maxlength="10" value="{{ getInput('sets.registermoney', $settings['registermoney']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[registermoney]') }}</div>
    </div>

    <button class="btn btn-primary">Сохранить</button>
</form>
