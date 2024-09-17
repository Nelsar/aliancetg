

<div class="tab-content col-md-12" id="custom-tabs-one-tabContent">
    <div class="tab-pane active in" id="custom-tabs-one-ru" role="tabpanel" aria-labelledby="custom-tabs-one-ru-tab">
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="header_ru" class="control-label">{{ 'Название' }}</label>
            <input class="form-control" name="name" type="text" id="name" value="{{ isset($categories->name) ? $categories->name : old('name')}}" >
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
            <label for="image" class="control-label">{{ 'Фото' }}</label>
            <input class="form-control" name="image" type="file" id="image" value="{{ isset($categories->image)}}" >
            {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
        </div>
        @if (isset($categories->image))
            <div class="form-group">
                <img src="{{ \Config::get('constants.alias.cdn_url').$categories->image }}" alt="" width="300px;">
            </div>
        @endif
    </div>

</div>

<br>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Создать' }}">
</div>
<script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
<script>
    document.querySelectorAll('.ckeditor_textarea').forEach(function(element) {
        CKEDITOR.replace(element);
    });

</script>
