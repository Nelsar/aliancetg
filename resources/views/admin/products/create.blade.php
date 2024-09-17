@extends('adminlte::page')

@section('title', 'Добавление товара')

@section('content_header')
    <h1>Добавление товара</h1>
@stop

@section('content')
<div class="card-body">
        <a href="{{ url('/admin/products') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>Назад</button></a>
        <br />
        <br />
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('products.store') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @include ('admin.products.form', ['formMode' => 'create'])

        </form>

    </div>
@endsection