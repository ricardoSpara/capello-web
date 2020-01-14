@extends('adminlte::page')

@section('title', 'Capello')

@section('content')
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="{{asset('img/slides/1.jpg')}}">
            </div>
            <div class="item">
                <img src="{{asset('img/slides/2.jpg')}}">
            </div>
            <div class="item">
                <img src="{{asset('img/slides/3.jpg')}}">
            </div>
            <div class="item">
                <img src="{{asset('img/slides/4.jpg')}}">
            </div>
            <div class="item">
                <img src="{{asset('img/slides/5.jpg')}}">
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <div class="box">
        <div class="box-header">
            <h1>Ranking de projetos</h1>
        </div>
        <div class="box-body">
        @if(count($projects) > 0)
            <table class="table table-bordered table-hover">
                <thead>
                    <th></th>
                    <th>Curtidas</th>
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
                        <td>{{$project->count_likes}}</td>
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
                                    <a href="#" data-toggle="tooltip" data-placement="bottom" title="{{$project->like > 0 ? 'Desfazer' : 'Curtir'}}" onclick="like('{{$project->id}}', this, true);" class="btn btn-default btn-sm" ><i style="color: {{$project->like > 0 ? '#0073b7' : ''}};" class="fa {{$project->like > 0 ? 'fa-thumbs-up' : 'fa-thumbs-o-up'}} fa-lg" aria-hidden="true"></i></a>
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
@stop

@section('js')
<script src="{{asset('js/functions.js')}}"></script>
<script>
$('.carousel').carousel({
    interval: 4000
});
</script>
@endsection