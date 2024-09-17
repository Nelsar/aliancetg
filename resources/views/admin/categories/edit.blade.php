@extends('adminlte::page')

@section('content_header')
    <h1>Измение категории</h1>
@stop

@section('content')
    <div class="card-body">
        <a href="{{ url('/admin/categories') }}" title="Назад"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
        <br />
        <br />

        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ route('categories.update', $categories) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            @include('admin.categories.form', ['formMode' => 'edit'])
        </form>

    </div>
@endsection