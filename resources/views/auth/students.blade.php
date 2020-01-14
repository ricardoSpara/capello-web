@extends('adminlte::page')

@section('title', 'Solicitações de alunos')

@section('content_header')
    <h1>Solicitações de alunos</h1>
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.css"/>
@endsection

@section('content')
    <div class="box">
        <div class="box-body">
            @if(count($students) > 0)
                    <table class="table table-bordered table-hover" id="studentsTable" data-order='[[ 1, "asc" ]]'>
                        <thead>
                            <th class="text-center">Aluno</th>
                            <th class="text-center">Nome</th>
                            <th class="text-center">CPF</th>
                            <th class="text-center">RA</th>
                            <th class="text-center">Curso</th>
                            <th class="text-center">Ano</th>
                            <th class="text-center">Aprovação?</th>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                            <tr>
                                <td class="text-center" style="text-align: center; vertical-align: middle;">
                                    <label class="text-center" style="text-align: center; vertical-align: middle;">    
                                        <div class="circle-small" id="profilePic" style="background-image: url({{$student->image ? asset('storage/users/'.$student->image) : asset('img/profile.png')}})"></div>
                                    </label>
                                </td>
                                <td class="text-center" style="text-align: center; vertical-align: middle;">{{$student->name}}</td>
                                <td class="text-center" style="text-align: center; vertical-align: middle;">{{$student->cpf}}</td>
                                <td class="text-center" style="text-align: center; vertical-align: middle;">{{$student->ra}}</td>
                                <td class="text-center" style="text-align: center; vertical-align: middle;">{{$student->course_name}}</td>
                                <td class="text-center" style="text-align: center; vertical-align: middle;">{{$student->degree}}º ano</td>
                                <td class="text-center" style="text-align: center; vertical-align: middle;">
                                    <a href="#" onclick="mdApprove(`{{route('students.storeApprove', ['id' => $student->id, 'what' => 'approve'])}}`, '#approveStudent')" class="btn btn-sm btn-success"><i class="fa fa-check"></i></a>
                                    <a href="#" onclick="mdApprove(`{{route('students.storeApprove', ['id' => $student->id, 'what' => 'decline'])}}`, '#declineStudent')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            @endforeach 
                        </tbody>
                    </table>
            @else
            <h1 class="text-center">Não há solicitações de alunos no momento! <i class="fa fa-thumbs-down" aria-hidden="true"></i></h1>
            @endif
        </div>
    </div>

    <div class="modal modal-success fade" id="approveStudent">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Aprovar aluno?</h4>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja aprovar esse aluno?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fechar</button>
                        <a href="" id="linkRoute"><button type="button" class="btn btn-outline">Aprovar</button></a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

    <div class="modal modal-danger fade" id="declineStudent">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Rejeitar aluno?</h4>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja rejeitar esse aluno?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Fechar</button>
                        <a href="" id="linkRoute"><button type="button" class="btn btn-outline">Rejeitar</button></a>
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
            $('#studentsTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                },
                "columns": [
                    { "orderable": false },
                    null,
                { "orderable": false },
                null,
                null,
                null,
                { "orderable": false },
            ]
        });
    });
</script>
@stop