@extends('adminlte::page')

@section('title', 'Изменение товара')

@section('content_header')
    <h1>Изменение товара</h1>
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

        <form method="POST" action="{{ url('/admin/products/update') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            @include ('admin.products.form', ['formMode' => 'edit'])

        </form>
    </div>
@endsection