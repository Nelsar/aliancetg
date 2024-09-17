@extends('adminlte::page')

@section('content_header')
    <h1>Товары</h1>
@stop

@section('content')

<div class="card-body">
    <a href="{{ url('/admin/products/create') }}" class="btn btn-success btn-sm" title="Добавить новый товар">
        <i class="fa fa-plus" aria-hidden="true"></i>Добавить
    </a>
    <form method="GET" action="{{ url('/admin/products') }}" accept-charset="UTF-8"
        class="form-inline my-2 my-lg-0 float-right" role="search">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Поиск..."
                value="{{ request('search') }}">
            <span class="input-group-append">
                <button class="btn btn-secondary">
                    <i class="fa-fa-search"></i>
                </button>
            </span>
        </div>
    </form>
    <br/>
    <br/>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Название товара</th>
                    <th>Изображение</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name ? Str::limit($product->name, 50) : '' }}</td>
                    @if(isset($product->image))
                    <td><img src="{{ url($product->image)}}" alt="{{ $product->image }}" width="50px;"></td>
                    @endif
                    <td>
                    <a href="{{ url('/admin/products/' . $product->id . '/edit') }}" title="Редактировать товар">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"
                                                                            aria-hidden="true"></i> Редактировать
                        </button>
                    </a>

                    <form method="POST" action="{{ url('/admin/products' . '/' . $product->id) }}"
                                    accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить товар"
                                            onclick="return confirm(&quot;Удалить?&quot;)"><i class="fa fa-trash-alt"
                                                                                            aria-hidden="true"></i>
                                        Удалить
                                    </button>
                                </form>
                    </td>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-wrapper"> {!! $products->appends(['search' => Request::get('search')])->render() !!} </div>
    </div>
</div>
@endsection