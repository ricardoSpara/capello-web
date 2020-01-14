@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'register-page')

@section('body')
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">{{ trans('adminlte::adminlte.register_message') }}</p>
            <form action="{{ url(config('adminlte.register_url', 'register')) }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="form-group text-center has-feedback {{ $errors->has('image') ? 'has-error' : '' }}">
                    <label class="text-center">
                        <div class="circle" id="profilePic" style="background-image: url({{asset('img/profile.png')}})"></div>
                        <input type="file" style="display: none;" name="image" class="form-control" value="{{ old('image') }}">
                    </label>
                    @if ($errors->has('image'))
                        <span class="help-block">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                           placeholder="{{ trans('adminlte::adminlte.full_name') }}">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="{{ trans('adminlte::adminlte.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.retype_password') }}">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('cpf') ? 'has-error' : '' }}">
                    <input type="text" name="cpf" class="form-control"
                           placeholder="CPF" value="{{ old('cpf') }}">
                    <span class="glyphicon glyphicon-credit-card form-control-feedback"></span>
                    @if ($errors->has('cpf'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cpf') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('birth') ? 'has-error' : '' }}">
                    <input type="text" name="birth" class="form-control"
                           placeholder="Data de nascimento" value="{{ old('birth') }}">
                    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                    @if ($errors->has('birth'))
                        <span class="help-block">
                            <strong>{{ $errors->first('birth') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('gender') ? 'has-error' : '' }}">
                    <select name="gender" id="" class="form-control">
                        <option value="">Selecione um gênero</option>
                        <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Feminino</option>
                        <option value="I" {{ old('gender') == 'I' ? 'selected' : '' }}>Prefiro não responder</option>
                    </select>
                    @if ($errors->has('gender'))
                        <span class="help-block">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <input type="text" name="phone" class="form-control"
                           placeholder="Telefone/Celular" value="{{ old('phone') }}">
                    <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('description') ? 'has-error' : '' }}">
                    <textarea name="description" class="form-control" placeholder="Sobre mim" cols="30" rows="10">{{ old('description') }}</textarea>
                    <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="isStudent" id="isStudent"> Sou estudante
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="isTeacher" id="isTeacher"> Sou professor
                            </label>
                        </div>
                    </div>
                </div>
                <div class="div-course hidden form-group has-feedback {{ $errors->has('course_id') ? 'has-error' : '' }}">
                    <select name="course_id" class="form-control">
                        <option value="">Selecione um curso</option>
                        <option value="1" {{ old('course_id') == 1 ? 'selected' : '' }}>Informática</option>
                        <option value="2" {{ old('course_id') == 2 ? 'selected' : '' }}>Eletrônica</option>
                        <option value="3" {{ old('course_id') == 3 ? 'selected' : '' }}>Mecânica</option>
                    </select>
                    @if ($errors->has('course_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('course_id') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="div-degree hidden form-group has-feedback {{ $errors->has('degree') ? 'has-error' : '' }}">
                    <select name="degree" class="form-control" value="{{ old('degree') }}">
                        <option value="">Selecione o ano</option>
                        <option value="1" {{ old('degree') == 1 ? 'selected' : '' }}>1º Ano</option>
                        <option value="2" {{ old('degree') == 2 ? 'selected' : '' }}>2º Ano</option>
                        <option value="3" {{ old('degree') == 3 ? 'selected' : '' }}>3º Ano</option>
                    </select>
                    @if ($errors->has('degree'))
                        <span class="help-block">
                            <strong>{{ $errors->first('degree') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="div-ra hidden form-group has-feedback {{ $errors->has('ra') ? 'has-error' : '' }}">
                    <input type="text" class="form-control" name="ra" placeholder="RA" value="{{ old('ra') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('ra'))
                        <span class="help-block">
                            <strong>{{ $errors->first('ra') }}</strong>
                        </span>
                    @endif
                </div>
                
                <button type="submit"
                        class="btn btn-primary btn-block btn-flat"
                >{{ trans('adminlte::adminlte.register') }}</button>
            </form>
            <div class="auth-links">
                <a href="{{ url(config('adminlte.login_url', 'login')) }}"
                   class="text-center">{{ trans('adminlte::adminlte.i_already_have_a_membership') }}</a>
            </div>
        </div>
        <!-- /.form-box -->
    </div><!-- /.register-box -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#isStudent').click(function() {
                if($(this).is(':checked')) {
                    $('#isTeacher').prop('checked', false);
                    $('.div-course').removeClass('hidden');
                    $('.div-degree').removeClass('hidden');
                    $('.div-ra').removeClass('hidden');
                } else {
                    $('.div-course').addClass('hidden');
                    $('.div-degree').addClass('hidden');
                    $('.div-ra').addClass('hidden');
                }
            });
            $('#isTeacher').click(function() {
                if($(this).is(':checked')) {
                    $('#isStudent').prop('checked', false);
                    $('.div-course').removeClass('hidden');
                    $('.div-degree').addClass('hidden');
                    $('.div-ra').addClass('hidden');
                } else {
                    $('.div-course').addClass('hidden');
                }
            });
        });
    </script>

    @yield('js')
    <script src="{{asset('js/auth.js')}}"></script>
    <script src="{{asset('js/jquery.mask.js')}}"></script>
    <script src="{{asset('js/masks.js')}}"></script>
@stop

