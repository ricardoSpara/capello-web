@extends('adminlte::page')

@section('title', 'Cadastrar projeto')

@section('content_header')
    <h1>Cadastrar projeto</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-body">
            @include('helpers.errors')
            @include('helpers.success')
            <form action="{{route('projects.store')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>
                            <div class="projectImage" id="imageMain" style="background-image: url({{asset('img/project.png')}})">
                            <input type="file" style="display: none;" name="image" class="form-control" value="{{ old('image') }}">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label><b>Título do projeto</b></label>
                            <input type="text" class="form-control" name="title" placeholder="Ex.:" value="{{old('title')}}">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label><b>Data de início</b></label>
                            <input type="date" class="form-control" name="started_date" value="{{old('started_date')}}">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label><b>Data de término (se finalizado)</b></label>
                            <input type="date" class="form-control" name="finished_date" value="{{old('finished_date')}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label><b>Descrição do projeto</b></label>
                            <textarea style="resize: none;" name="description" class="form-control" cols="30" rows="10" placeholder="Digite algo bem legal ;)">{{old('description')}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Cursos que estão envolvidos nesse projeto</label>
                            <select name="courses[]" id="" class="select2 form-control" multiple>
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}" {{old('courses') !== null && in_array($course->id, old('courses')) ? 'selected' : ''}}>{{$course->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Alunos que estão participando</label>
                            <select name="users[]" id="" class="select2 form-control" multiple>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" {{(old('users') !== null && in_array($user->id, old('users'))) || ($user->id == Auth::user()->id)  ? 'selected' : ''}}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Tags para identificação do projeto</label>
                            <select name="tags[]" id="" class="select2 form-control" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}" {{old('tags') !== null && in_array($tag->id, old('tags')) ? 'selected' : ''}}>{{$tag->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Documentos</label>
                            <input type="file" name="files[]" class="form-control" multiple>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label><input type="checkbox" class="iCheck" name="private" {{old('private') !== null ? 'checked' : ''}}> Esse é um projeto privado?</label>
                        </div>
                    </div>  
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Cadastrar projeto</button>
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
<script>
    $('.select2').select2({
        multiple: true
    });
    // $('.iCheck').icheck();

    $('input[name="image"]').on('change', function() {
        let file = $(this)[0].files[0];
        if(file.name.endsWith('jpeg') || file.name.endsWith('jpg') || file.name.endsWith('png')) {
            getBase64(file);
        } else {
            alert('Insira um formato jpeg,jpg ou png');
        }

    });

    function getBase64(file) {
        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function () {
            $('#imageMain').css('background-image', "url('"+reader.result+"')");
        };
        reader.onerror = function (error) {
        console.log('Error: ', error);
        };
    }
</script>
@stop