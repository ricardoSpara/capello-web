@extends('adminlte::page')

@section('title', 'Editar curso')

@section('content_header')
    <h1>Editar curso</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-body">
            @include('helpers.errors')
            @include('helpers.success')
            <form action="{{route('courses.update', ['id' => $course->id])}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label><b>Nome do curso</b></label>
                            <input type="text" class="form-control" name="name" placeholder="Ex.:" value="{{$course->name}}">
                        </div>
                    </div>  
                    <div class="col-md-2 col-sm-12">
                        <label>Salvar</label>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @yield('js')
    
@stop

@section('js')
<script src="{{asset('js/jquery.mask.js')}}"></script>
<script src="{{asset('js/masks.js')}}"></script>
@stop