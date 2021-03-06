@section('header')
    <h1>Форум / Галерея</h1>
@stop

<form action="/admin/settings?act=forum" method="post">
    @csrf
    <div class="form-group{{ hasError('sets[forumtem]') }}">
        <label for="forumtem">Тем в форуме на стр.:</label>
        <input type="number" class="form-control" id="forumtem" name="sets[forumtem]" maxlength="2" value="{{ getInput('sets.forumtem', $settings['forumtem']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[forumtem]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[forumpost]') }}">
        <label for="forumpost">Сообщений в форуме на стр.:</label>
        <input type="number" class="form-control" id="forumpost" name="sets[forumpost]" maxlength="2" value="{{ getInput('sets.forumpost', $settings['forumpost']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[forumpost]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[forumtextlength]') }}">
        <label for="forumtextlength">Символов в сообщении форума:</label>
        <input type="number" class="form-control" id="forumtextlength" name="sets[forumtextlength]" maxlength="5" value="{{ getInput('sets.forumtextlength', $settings['forumtextlength']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[forumtextlength]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[forumloadsize]') }}">
        <label for="forumloadsize">Максимальный вес файла (Mb):</label>
        <input type="number" class="form-control" id="forumloadsize" name="sets[forumloadsize]" maxlength="2" value="{{ getInput('sets.forumloadsize', round($settings['forumloadsize'] / 1048576)) }}" required>
        <div class="invalid-feedback">{{ textError('sets[forumloadsize]') }}</div>

        <input type="hidden" value="1048576" name="mods[forumloadsize]">
        <span class="text-muted font-italic">Ограничение сервера: {{ ini_get('upload_max_filesize') }}</span>
    </div>

    <div class="form-group{{ hasError('sets[forumextload]') }}">
        <label for="forumextload">Допустимые расширения файлов:</label>
        <textarea class="form-control" id="forumextload" name="sets[forumextload]" required>{{ getInput('sets.forumextload', $settings['forumextload']) }}</textarea>
        <div class="invalid-feedback">{{ textError('sets[forumextload]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[forumloadpoints]') }}">
        <label for="forumloadpoints">Актива для загрузки файлов:</label>
        <input type="number" class="form-control" id="forumloadpoints" name="sets[forumloadpoints]" maxlength="4" value="{{ getInput('sets.forumloadpoints', $settings['forumloadpoints']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[forumloadpoints]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[fotolist]') }}">
        <label for="fotolist">Kол-во фото на стр.</label>
        <input type="number" class="form-control" id="fotolist" name="sets[fotolist]" maxlength="2" value="{{ getInput('sets.fotolist', $settings['fotolist']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[fotolist]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[postgallery]') }}">
        <label for="postgallery">Комментариев на страницу в галерее</label>
        <input type="number" class="form-control" id="postgallery" name="sets[postgallery]" maxlength="3" value="{{ getInput('sets.postgallery', $settings['postgallery']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[postgallery]') }}</div>
    </div>

    <div class="form-group{{ hasError('sets[photogroup]') }}">
        <label for="photogroup">Групп на страницу в галерее:</label>
        <input type="number" class="form-control" id="photogroup" name="sets[photogroup]" maxlength="2" value="{{ getInput('sets.photogroup', $settings['photogroup']) }}" required>
        <div class="invalid-feedback">{{ textError('sets[photogroup]') }}</div>
    </div>

    <button class="btn btn-primary">Сохранить</button>
</form>
