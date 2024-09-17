@extends('adminlte::page')

@section('title', 'Список Отделений')

@section('content_header')
    <h1>Список Отделений</h1>
@stop

@section('content')

<div class="cart-body">
    
    <a href="{{ url('/admin/departments/create') }}" class="btn btn-success btn-sm" title="Добавить Отделение">
        <i class="fa fa-plus" aria-hidden="true">Добавить</i> 
    </a>

    <form method="GET" action="{{ url('/admin/departments') }}" accept-charset="UTF-8"
              class="form-inline my-2 my-lg-0 float-right" role="search">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Поиск..."
                       value="{{ request('search') }}">
                <span class="input-group-append">
                    <button class="btn btn-secondary" type="submit">
                        <i class="fa fa-search"></i>
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
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($departments as $department)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department->name ? Str::limit($department->name, 50) : '' }}</td>
                            <td>
                                <a href="{{ url('/admin/departments/' . $department->id . '/edit') }}" title="Редактировать категорию">
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"
                                                                            aria-hidden="true"></i> Редактировать
                                    </button>
                                </a>

                                <form method="POST" action="{{ url('/admin/departments' . '/' . $department->id) }}"
                                    accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить отделение"
                                            onclick="return confirm(&quot;Удалить?&quot;)"><i class="fa fa-trash-alt"
                                                                                            aria-hidden="true"></i>
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
            
        </div>

    </div>
</div>
@endsection