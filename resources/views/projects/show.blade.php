@extends('adminlte::page')

@section('title', 'Perfil do projeto')

@section('content_header')
    <h1>{{$project->title}}
        <a href="{{route('projects.index')}}"><button class="btn btn-danger pull-right"><i class="fa fa-chevron-left"></i> &nbsp; Voltar</button></a>
    </h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            @include('helpers.errors')
            @include('helpers.success')
            @if($auth->access_level == '5' || in_array("{$auth->id}", $auths))
                @if($project->status == 'Inativo')
                    <button class="btn btn-success pull-right" data-toggle="modal" data-target="#activeProject">Ativar <i class="fa fa-arrow-up" aria-hidden="true"></i></button>
                @else
                    <button class="btn btn-danger pull-right" data-toggle="modal" data-target="#deleteProject">Desativar <i class="fa fa-arrow-down" aria-hidden="true"></i></button>
                @endif
                <a href="{{route('projects.edit', ['id' => $project->id])}}"><button class="btn btn-primary pull-right" style="margin-right: 5px;">Editar <i class="fa fa-pencil" aria-hidden="true"></i></button></a>
            @endif
            <a href="#" onclick="like('{{$project->id}}', this)" style="margin-right: 5px;" class="btn btn-default pull-right" ><i style="color: {{$project->like > 0 ? '#0073b7' : ''}};" class="fa {{$project->like > 0 ? 'fa-thumbs-up' : 'fa-thumbs-o-up'}} fa-lg" aria-hidden="true"></i> <span style="color: {{$project->like > 0 ? '#0073b7' : ''}};">{{$project->like > 0 ? 'Desfazer' : 'Curtir'}}</span></a>

        </div>
        <div class="box-body">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <div class="projectImage" id="imageMain" style="background-image: url({{$project->image ? asset('storage/projects/'.$project->image) : asset('img/no-project.png')}})">
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <h3 class="m-blue"><b>Descrição</b></h3>
                <p class="text-justify">{{$project->description}}</p>
            </div>
            <div class="col-md-12 col-sm-12">
                <h3 class="m-blue"><b>Cursos que estão envolvidos no projeto</b></h3>
                <ul>
                    @foreach($courses as $course)
                        <li>{{$course->name}}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-12 col-sm-12">
                <h3 class="m-blue"><b>Alunos e professores participantes</b></h3>
                <ul>
                    @foreach($users as $user)
                        <li><b>{{$user->access_level == 3 ? 'Aluno' : 'Professor'}}</b> {{$user->name}} <small>({{$user->email}})</small></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-12 col-sm-12">
                <h3 class="m-blue"><b>Tags</b></h3>
                <ul>
                    @foreach($tags as $tag)
                        <li>{{$tag->name}}</li>
                    @endforeach
                </ul>
            </div>
            @if(isset($files) && $files)
            <div class="col-md-12 col-sm-12">
                <h3 class="m-blue"><b>Arquivos</b></h3>
                <table class="table table-bordered table-hover">
                    <thead>
                        <th>#</th>
                        <th>Nome (Caminho)</th>
                        <th>Tamanho (KB)</th>
                    </thead>
                    <tbody>
                        @foreach($files as $file)
                        <tr>
                            <td>{{$file->id}}</td>
                            <td><a href="{{Storage::url('files/'.$file->path)}}">{{$file->path}} <i class="fa fa-download" aria-hidden="true"></i></a></td>
                            <td>{{$file->size/1000}} KB</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
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
        <!-- /.modal -->
@stop

@section('js')
<script src="{{asset('js/functions.js')}}"></script>
@stop