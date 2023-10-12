@extends('layouts.plantillaErroes')
@section('cssExtra')
    <style>
        main {
            height: 100%;
        }
    </style>
@endsection
@section('error')
    <div id="layoutError">
        <div id="layoutError_content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center mt-4">
                            <img class="mb-4 img-error" src="{{ asset('img/imagenError.jpg') }}" />
                            <h1 class="display-1">500</h1>
                            <p class="lead">Error interno</p>
                            <a href="{{ route('home') }}">
                                <i class="fas fa-arrow-left me-1"></i>
                                Volver a inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
