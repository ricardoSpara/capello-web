@extends('adminlte::page')

@section('title', 'Cadastrar tag')

@section('content_header')
    <h1>Cadastrar tag</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-body">
            @include('helpers.errors')
            @include('helpers.success')
            <form action="{{route('tags.store')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label><b>Nome da tag</b></label>
                            <input type="text" class="form-control" name="name" placeholder="Ex.:" value="{{old('name')}}">
                        </div>
                    </div>  
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Curso envolvido</label>
                            <select name="course_id" id="" class="select2 form-control">
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}" {{old('courses') !== null && in_array($course->id, old('courses')) ? 'selected' : ''}}>{{$course->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <label>Salvar</label>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Cadastrar</button>
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