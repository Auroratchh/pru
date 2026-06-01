
@extends('layouts.template_01')

@section('title','Login')


@section('content')
    <section class="page-title-section top-position bg-img cover-background" data-overlay-dark="4" data-background="{{asset('img/banner/page-title.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Acceso a Cuenta</h1>
                </div>
                <div class="col-md-12">
                    <ul>
                        <li><a href="{{asset('/')}}">Inicio</a></li>
                        <li><a href="javascript:void(0);">Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-7 col-xl-6">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! session('status')  !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('status_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! session('status_success')  !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                    @endif
                    @if (session('status_fail'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {!! session('status_fail')  !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="bg-white p-4 border border-width-5">
                        <div class="text-center section-heading">
                            <h2>Login</h2>

                        </div>
                        {!! Form::open(['url'=>'login','method' => 'POST', 'id'=>'FormRegister','class'=>'contact-form'])!!}

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('email', 'Email:',['class'=>'']) !!}
                                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Correo Electronico" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('password', 'Password:',['class'=>'']) !!}
                                    <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                    <label class="custom-control-label" for="remember">Recordarme</label>
                                </div>
                            </div>
                            <div class="col-sm-6 text-start text-sm-end">
                                <a href="{{ route('password.request') }}" class="m-link-muted">¿Olvistaste tu contraseña?</a>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4"><span>Accesar</span></button>


                        {!! Form::close()!!}

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </section>

    <input type="hidden" id="seccion_amc" value="#btn-inicio" />
@endsection

@section('javascript')

@endsection
