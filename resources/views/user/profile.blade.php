@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <h1>Meu Perfil</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header"><h3>{{$user->name}}</h3></div>
        <div class="box-body">
            @include('helpers.errors')
            @include('helpers.success')
            <form action="{{route('user.updateProfile')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="text-center">
                    <label class="text-center">
                    <div class="circle" id="profilePic" style="background-image: url({{$user->image ? asset('storage/users/'.$user->image) : asset('img/profile.png')}})"></div>
                        <input type="file" style="display: none;" name="image" class="form-control" value="{{ old('image') }}">
                    </label>
                </div>
                <div style="margin-top: 50px;"></div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label><b>Nome</b></label>
                        <input type="text" name="name" class="form-control" value="{{$user->name}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label><b>E-mail</b></label>
                        <input type="text" name="email" class="form-control" value="{{$user->email}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label><b>CPF</b></label>
                        <input type="text" name="cpf" class="form-control" value="{{$user->cpf}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label><b>Data de nascimento</b></label>
                        <input type="text" name="birth" class="form-control" value="{{$user->birth}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label><b>Gênero</b></label>
                        <select name="gender" class="form-control">
                            <option value="M" {{ $user->gender == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ $user->gender == 'F' ? 'selected' : '' }}>Feminino</option>
                            <option value="I" {{ $user->gender == 'I' ? 'selected' : '' }}>Prefiro não responder</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label><b>Telefone/Celular</b></label>
                        <input type="text" name="phone" class="form-control" value="{{$user->phone}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label><b>Sobre mim</b></label>
                        <textarea name="description" class="form-control" cols="30" rows="10">{{$user->description}}</textarea>
                    </div>
                </div>
                <div class="row">
                    @if($user->course_id)
                    <div class="form-group col-md-4">
                            <b>Curso</b>
                            <select name="course_id" disabled class="form-control">
                                <option value="1" {{ $user->course_id == 1 ? 'selected' : '' }}>Informática</option>
                                <option value="2" {{ $user->course_id == 2 ? 'selected' : '' }}>Eletrônica</option>
                                <option value="3" {{ $user->course_id == 3 ? 'selected' : '' }}>Mecânica</option>
                            </select>
                    </div>
                    @endif

                    @if($user->degree)
                    <div class="form-group col-md-4">
                            <b>Ano</b>
                            <select name="degree" disabled class="form-control">
                                <option value="1" {{ $user->degree == 1 ? 'selected' : '' }}>1º Ano</option>
                                <option value="2" {{ $user->degree == 2 ? 'selected' : '' }}>2º Ano</option>
                                <option value="3" {{ $user->degree == 3 ? 'selected' : '' }}>3º Ano</option>
                            </select>
                    </div>
                    @endif

                    @if($user->ra)
                    <div class="form-group col-md-4">
                            <b>RA</b>
                            <input type="text" disabled name="ra" class="form-control" value="{{$user->ra}}">
                    </div>
                    @endif
                </div>
                <div style="margin-top: 10px;"></div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-success btn-block">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @yield('js')
    
@stop

@section('js')
<script src="{{asset('js/auth.js')}}"></script>
<script src="{{asset('js/jquery.mask.js')}}"></script>
<script src="{{asset('js/masks.js')}}"></script>
@stop