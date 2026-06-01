@extends('layouts.template_00')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/programacion.css') }}">
@endsection

@section('content')
    <section class="pt-1 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}">Menú Administración</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Programación</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class= "main-container">
        <div class= "container-principal">
            

        
        </div>

    </section>

@endsection
