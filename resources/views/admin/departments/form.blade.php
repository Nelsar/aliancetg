

<div class="tab-content col-md-12" id="custom-tabs-one-tabContent">
    <div class="tab-pane active in" id="custom-tabs-one-ru" role="tabpanel" aria-labelledby="custom-tabs-one-ru-tab">
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="header_ru" class="control-label">{{ 'Название' }}</label>
            <input class="form-control" name="name" type="text" id="name" value="{{ isset($departments->name) ? $departments->name : old('name')}}" >
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="header_ru" class="control-label">{{ 'Адрес' }}</label>
            <input class="form-control" name="address" type="text" id="name" value="{{ isset($departments->address) ? $departments->address : old('address')}}" >
            {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
        </div>

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
