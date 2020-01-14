<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .circle {
            width: 200px;
            height: 200px;
            border-radius:100%;
            background-repeat: no-repeat;
            background-position: center; 
            background-size: 200px;
        }
        .circle-small {
            width: 70px;
            height: 70px;
            border-radius:100%;
            background-repeat: no-repeat;
            background-position: center; 
            background-size: 70px;
        }

        .projectImage {
            width: 100vw;
            height: 300px;
            background-repeat: no-repeat;
            background-position: center;  
            max-width: 100%;
        }

        .v-middle {
            vertical-align: middle;
        }

        .m-blue {
            color: #3c8dbc;
        }

        textarea {
            resize: none !important;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if($action == 'teachers')
        <h1>Professores</h1>
    @elseif($action == 'students')
        <h1>Alunos</h1>
    @elseif($action == 'guests')
        <h1>Visitantes</h1>
    @else
        <h1>Usuários</h1>
    @endif
    <table>
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>CPF</th>
                <!-- <th>Nascimento</th>
                <th>Gênero</th>
                <th>Telefone</th>
                @if($action == 'students')
                <th>Curso</th>
                <th>Ano</th>
                <th>RA</th>
                @elseif($action == 'teachers')
                <th>Curso</th>
                @elseif($action == "")
                <th>Tipo</th>
                @endif
                <th>Criado em</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    <div class="text-center">
                        <label class="text-center">
                            <div class="circle-small" id="profilePic" style="background-image: url({{$user->image ? asset('storage/users/'.$student->image) : asset('img/profile.png')}})"></div>
                        </label>
                    </div>
                </td>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->cpf}}</td>
                <!-- <td>{{$user->birth}}</td>
                <td>{{$user->gender}}</td>
                <td>{{$user->phone}}</td>
                @if($action == 'students')
                <td>{{$user->course_name}}</td>
                <td>{{$user->degree}}º ano</td>
                <td>{{$user->ra}}</td>
                @elseif($action == 'teachers')
                <td>{{$user->course_name}}</td>
                @elseif($action == "")
                <td>-</td>
                @endif
                <td>{{$user->created_at}}</td> -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>