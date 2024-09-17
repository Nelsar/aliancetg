@extends('adminlte::page')

@section('title', 'Корзина заказов')

@section('content_header')
    <h1>Корзины</h1>
@stop

@section('content')
    <div class="card-body">
    <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($carts as $cart)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cart->header ? Str::limit($cart->header, 50) : '' }}</td>
                            <td>
                                <a href="{{ url('/admin/carts/' . $cart->id . '/show') }}" title="Подробнее">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"
                                                                            aria-hidden="true"></i> Подробнее
                                    </button>
                                </a>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination-wrapper"> {!! $carts->appends(['search' => Request::get('search')])->render() !!} </div>
        </div>
    </div>
@endsection