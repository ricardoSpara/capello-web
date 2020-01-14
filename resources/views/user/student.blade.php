@extends('adminlte::page')

@section('title', 'Aluno')

@section('content_header')
    <h1>
        Aluno
        <a href="{{URL::previous()}}"><button class="btn btn-danger pull-right"><i class="fa fa-chevron-left"></i> &nbsp; Voltar</button></a>
    </h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3>
                {{$student->name}}
                @can('isTeacherHigher')
                @if($student->status == '1')
                    <button class="btn btn-success pull-right" data-toggle="modal" data-target="#activeStudent">Ativar <i class="fa fa-arrow-up" aria-hidden="true"></i></button>
                @else
                    <button class="btn btn-danger pull-right" data-toggle="modal" data-target="#deleteStudent">Desativar <i class="fa fa-arrow-down" aria-hidden="true"></i></button>
                @endif
                @endcan
            </h3>
        </div>
        <div class="box-body">
            @include('helpers.errors')
            @include('helpers.success')
            <div class="text-center">
                <label class="text-center">
                <div class="circle" id="profilePic" style="background-image: url({{$student->image ? asset('storage/users/'.$student->image) : asset('img/profile.png')}})"></div>
                </label>
            </div>
            <div style="margin-top: 50px;"></div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label><b>Nome</b></label>
                    <p>{{$student->name}}</p>
                </div>
                <div class="form-group col-md-6">
                    <label><b>E-mail</b></label>
                    <p>{{$student->email}}</p>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label><b>CPF</b></label>
                    <p>{{$student->cpf}}</p>
                </div>
                <div class="form-group col-md-3">
                    <label><b>Data de nascimento</b></label>
                    <p>{{$student->birth}}</p>
                </div>
                <div class="form-group col-md-3">
                    <label><b>Gênero</b></label>
                    @if($student->gender == 'M')
                        <p>Masculino</p>
                    @elseif($student->gender == 'F')
                        <p>Feminino</p>
                    @else
                        <p>Não declarado</p>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label><b>Telefone/Celular</b></label>
                    <p>{{$student->phone}}</p>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label><b>Sobre mim</b></label>
                    <textarea name="description" class="form-control" cols="30" rows="10" readonly>{{$student->description}}</textarea>
                </div>
            </div>
            <div class="row">
                @if($student->course_id)
                <div class="form-group col-md-4">
                    <b>Curso</b>
                    <p>{{$student->course_name}}</p>    
                </div>
                @endif

                @if($student->degree)
                <div class="form-group col-md-4">
                    <b>Ano</b>
                    <p>{{$student->degree}}º ano</p>
                </div>
                @endif

                @if($student->ra)
                <div class="form-group col-md-4">
                    <b>RA</b>
                    <p>{{$student->ra}}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" id="deleteStudent">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Desativar aluno</h4>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja desativar esse aluno?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fechar</button>
                        <a href="{{route('students.deleteStudents', ['id' => $student->id])}}"><button type="button" class="btn btn-outline">Desativar</button></a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

    <div class="modal modal-success fade" id="activeStudent">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ativar aluno</h4>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja ativar esse aluno?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fechar</button>
                        <a href="{{route('students.deleteStudents', ['id' => $student->id])}}"><button type="button" class="btn btn-outline">Ativar</button></a>
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
@stop