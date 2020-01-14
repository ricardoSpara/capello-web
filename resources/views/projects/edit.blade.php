@extends('adminlte::page')

@section('title', 'Editar projeto')

@section('content_header')
    <h1>Editar projeto
    <a href="{{URL::previous()}}"><button class="btn btn-danger pull-right"><i class="fa fa-chevron-left"></i> &nbsp; Voltar</button></a>
    </h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            @if($project->status == 'Inativo')
                <button class="btn btn-success pull-right" data-toggle="modal" data-target="#activeProject">Ativar <i class="fa fa-arrow-up" aria-hidden="true"></i></button>
            @else
                <button class="btn btn-danger pull-right" data-toggle="modal" data-target="#deleteProject">Desativar <i class="fa fa-arrow-down" aria-hidden="true"></i></button>
            @endif
        </div>
        <div class="box-body">
            
            @include('helpers.errors')
            @include('helpers.success')
            <form action="{{route('projects.update', ['id' => $project->id])}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label>
                            <div class="projectImage" id="imageMain" style="background-image: url({{$project->image ? asset('storage/projects/'.$project->image) : asset('img/no-project.png')}})">
                            <input type="file" style="display: none;" name="image" class="form-control" value="{{ $project->image }}">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label><b>Título do projeto</b></label>
                            <input type="text" class="form-control" name="title" placeholder="Ex.:" value="{{$project->title}}">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label><b>Data de início</b></label>
                            <input type="date" class="form-control" name="started_date" value="{{$started_date}}">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="form-group">
                            <label><b>Data de término (se finalizado)</b></label>
                            <input type="date" class="form-control" name="finished_date" value="{{$finished_date}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label><b>Descrição do projeto</b></label>
                            <textarea style="resize: none;" name="description" class="form-control" cols="30" rows="10" placeholder="Digite algo bem legal ;)">{{$project->description}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Cursos que estão envolvidos nesse projeto</label>
                            <select name="courses[]" id="" class="select2 form-control" multiple>
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}" {{$idsCourses !== null && in_array($course->id, $idsCourses) ? 'selected' : ''}}>{{$course->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Alunos que estão participando</label>
                            <select name="users[]" id="" class="select2 form-control" multiple>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" {{$idsUsers !== null && in_array("$user->id", $idsUsers) ? 'selected' : ''}}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Tags para identificação do projeto</label>
                            <select name="tags[]" id="" class="select2 form-control" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}" {{$idsTags !== null && in_array("$tag->id", $idsTags) ? 'selected' : ''}}>{{$tag->name}}</option>
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
                        @if(isset($files) && $files)
                        <div class="col-md-12 col-sm-12">
                            <h3 class="m-blue"><b>Arquivos</b></h3>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <th>#</th>
                                    <th>Nome (Caminho)</th>
                                    <th>Tamanho (KB)</th>
                                    <th>Ações</th>
                                </thead>
                                <tbody>
                                    @foreach($files as $file)
                                    <tr>
                                        <td>{{$file->id}}</td>
                                        <td><a href="{{Storage::url('files/'.$file->path)}}">{{$file->path}} <i class="fa fa-download" aria-hidden="true"></i></a></td>
                                        <td>{{$file->size/1000}} KB</td>
                                        <td>
                                            <a href="#" class="btn btn-danger btn-sm" onclick="mdApprove(`{{route('projects.deleteFile', ['path' => $file->path])}}`, '#deleteFile')"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label><input type="checkbox" class="iCheck" name="private" {{$project->private == '1' ? 'checked' : ''}}> Esse é um projeto privado?</label>
                        </div>
                    </div>  
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar projeto</button>
                        </div>
                    </div>  
                </div>
            </form>
        </div>
    </div>

    <div class="modal modal-danger fade" id="deleteFile">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Deletar arquivo</h4>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja deletar esse arquivo?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fechar</button>
                    <a href="" id="linkRoute"><button type="button" class="btn btn-outline">Deletar</button></a>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal modal-success fade" id="activeProject">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ativar projeto</h4>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja ativar esse projeto?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fechar</button>
                        <a href="{{route('projects.active', ['id' => $project->id])}}" id="linkRoute"><button type="button" class="btn btn-outline">Ativar</button></a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

    <div class="modal modal-danger fade" id="deleteProject">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Desativar projeto</h4>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja desativar esse projeto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fechar</button>
                    <a href="{{route('projects.delete', ['id' => $project->id])}}"><button type="button" class="btn btn-outline">Desativar</button></a>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    
@stop

@section('js')
<script src="{{asset('js/jquery.mask.js')}}"></script>
<script src="{{asset('js/masks.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>
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