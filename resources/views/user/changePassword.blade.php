@extends('adminlte::page')

@section('title', 'Mudar senha')

@section('content_header')
    <h1>Mudar senha</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-body">
            @include('helpers.errors')
            @include('helpers.success')
            <form action="{{route('user.storeNewPassword')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label><b>Senha atual</b></label>
                            <input type="password" class="form-control" name="password" placeholder="••••••">
                        </div>
                    </div>  
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label><b>Repita a senha atual</b></label>
                            <input type="password" class="form-control" name="repeat_password" placeholder="••••••"> 
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label><b>Nova senha</b></label>
                            <input type="password" class="form-control" name="new_password" placeholder="••••••"> 
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Salvar alterações</button>
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