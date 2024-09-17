
<div class="tab-content col-md-12" id="custom-tabs-one-tabContent">
    <br>
    <label for="social_facts_id_" class="control-label">{{ 'Выберите категорию' }}</label>
    <select id="social_facts_id" class="form-control" name="category_id">
        @foreach($categories as $category)
            <option value="{{ $category->id }}">
                {{ $category->name}}
            </option>
        @endforeach
    </select>
    <label for="social_facts_id_" class="control-label">{{ 'Выберите название бренда' }}</label>
    <select id="social_facts_id" class="form-control" name="brand_id">
        @foreach($brands as $brand)
            <option value="{{ $brand->id }}">
                {{ $brand->name}}
            </option>
        @endforeach
    </select>
    <div class="tab-pane active in" id="custom-tabs-one-ru" role="tabpanel" aria-labelledby="custom-tabs-one-ru-tab">
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="header_ru" class="control-label">{{ 'sku' }}</label>
            <input class="form-control" name="sku" type="text" id="header_ru" value="{{ isset($products->sku) ? $products->sku : old('sku') }}" >
            
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="header_ru" class="control-label">{{ 'Артикул' }}</label>
            <input class="form-control" name="article" type="number" id="header_ru" value="{{ isset($products->article) ? $products->article : old('article') }}" >
            {!! $errors->first('header[ru]"', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="header_ru" class="control-label">{{ 'Название' }}</label>
            <input class="form-control" name="name" type="text" id="header_ru" value="{{ isset($products->name) ? $products->name : old('name') }}" >
            {!! $errors->first('header[ru]"', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="header_ru" class="control-label">{{ 'Полное название' }}</label>
            <input class="form-control" name="fullName" type="text" id="header_ru" value="{{ isset($products->fullName) ? $products->fullName : old('fullName') }}" >
            {!! $errors->first('header[ru]"', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="header_ru" class="control-label">{{ 'Полное описание' }}</label>
            <textarea class="form-control" name="description" type="text" id="header_ru" value="{{ isset($products->description) ? $products->description : old('description') }}" ></textarea>
            {!! $errors->first('header[ru]"', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            <label for="header_ru" class="control-label">{{ 'Цена' }}</label>
            <input class="form-control" name="price" type="number" id="header_ru" value="{{ isset($products->price) ? $products->price : old('price') }}" >
            
        </div>
        <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
            <label for="image" class="control-label">{{ 'Фото' }}</label>
            <input class="form-control" name="image" type="file" id="image" value="{{ isset($products->image)}}" >
            {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
        </div>
        @if (isset($products->image))
            <div class="form-group">
                <img src="{{ \Config::get('constants.alias.cdn_url').$products->image }}" alt="" width="300px;">
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
