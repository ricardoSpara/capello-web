@extends('adminlte::page')

@section('title', 'Projetos')

@section('content_header')
@if(isset($my))
    <h1>Meus Projetos</h1>
@else
    <h1>Projetos</h1>
@endif
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css"/>
@endsection

@section('content')
    <div class="box">
        <div class="box-body">
            @include('helpers.errors')
            @include('helpers.success')
            @if(count($projects) > 0)
                    <table class="table table-bordered table-hover" id="projectsTable" data-order='[[ 1, "asc" ]]'>
                        <thead>
                            <th></th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Ínicio</th>
                            <th>Término</th>
                            <th>Cursos</th>
                            <th>Tags</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                            <tr>
                                <td><img src="{{$project->image ? Storage::url('projects/'.$project->image) : asset('img/no-project.png')}}" width="70"></td>
                                <td class="text-center" style="text-align: center; vertical-align: middle;">{{$project->title}}</td>
                                <td>{{strlen($project->description) > 50 ? substr($project->description, 0, -strlen($project->description)+50).'...'  : $project->description }}</td>
                                <td class="text-center" style="text-align: center; vertical-align: middle;">{{$project->started_date}}</td>
                                <td class="text-center" style="text-align: center; vertical-align: middle;">{{$project->finished_date}}</td>
                                <td>
                                    @foreach($project->courses as $course)
                                        @if($course->id==1)
                                            <small class="label bg-blue">{{$course->name}}</small>
                                        @elseif($course->id==2)
                                            <small class="label bg-gray">{{$course->name}}</small>
                                        @elseif($course->id==3)
                                            <small class="label bg-black">{{$course->name}}</small>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($project->tags as $tag)
                                        @if($tag->course_id==1)
                                            <small class="label bg-blue">{{$tag->name}}</small>
                                        @elseif($tag->course_id==2)
                                            <small class="label bg-gray">{{$tag->name}}</small>
                                        @elseif($tag->course_id==3)
                                            <small class="label bg-black">{{$tag->name}}</small>
                                        @endif
                                    
                                    @endforeach
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    <a data-toggle="tooltip" data-placement="top" title="Visualizar" href="{{route('projects.show', ['id' => $project->id])}}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                    @if(isset($my))
                                    <a href="{{route('projects.edit', ['id' => $project->id])}}" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>
                                    @if($project->status == 'Inativo')
                                        <div class="form-group">
                                            <a href="#" onclick="mdApprove(`{{route('projects.active', ['id' => $project->id])}}`, '#activeProject')" class="btn btn-success btn-sm"><i class="fa fa-arrow-up fa-lg" aria-hidden="true"></i></a>
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <a href="#" onclick="mdApprove(`{{route('projects.delete', ['id' => $project->id])}}`, '#deleteProject')" class="btn btn-danger btn-sm" ><i class="fa fa-arrow-down fa-lg" aria-hidden="true"></i></a>
                                        </div>
                                    @endif
                                    @endif
                                        <br>
                                        <div class="form-group" style="margin-top: 3px;">
                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="{{$project->like > 0 ? 'Desfazer' : 'Curtir'}}" onclick="like('{{$project->id}}', this)" class="btn btn-default btn-sm" ><i style="color: {{$project->like > 0 ? '#0073b7' : ''}};" class="fa {{$project->like > 0 ? 'fa-thumbs-up' : 'fa-thumbs-o-up'}} fa-lg" aria-hidden="true"></i></a>
                                        </div>
                                </td>
                            </tr>
                            @endforeach 
                        </tbody>
                    </table>
            @else
            <h1 class="text-center">Não há projetos no momento! <i class="fa fa-thumbs-down" aria-hidden="true"></i></h1>
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
                        <a href="" id="linkRoute"><button type="button" class="btn btn-outline">Ativar</button></a>
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
                        <a href="" id="linkRoute"><button type="button" class="btn btn-outline">Desativar</button></a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    
@stop

@section('js')
<script src="{{asset('js/auth.js')}}"></script>
<script src="{{asset('js/jquery.mask.js')}}"></script>
<script src="{{asset('js/masks.js')}}"></script>
<script src="{{asset('js/functions.js')}}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#projectsTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
            },
            "columns": [
                { "orderable": false },
                null,
                null,
                null,
                null,
                null,
                null,
                { "orderable": false },
            ]
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@stop