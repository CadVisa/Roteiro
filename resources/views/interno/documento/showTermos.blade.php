@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-file-lines me-1"></i>Documentos legais</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span class="me-auto">
                    <i class="fa-solid fa-file-contract me-1"></i>
                    Detalhes dos Termos de Uso
                </span>
            
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <a href="{{ route('documento.index') }}" class="spinner-light btn btn-sm btn-outline-light">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span class="d-none d-sm-inline">Voltar</span>
                    </a>
            
                    <a class="btn btn-sm btn-outline-light" href="{{ route('documento.editTermos', ['documento' => $documento->id]) }}">
                        <i class="fa-regular fa-pen-to-square"></i>
                        <span class="d-none d-sm-inline">Editar</span>
                    </a>
                </div>
            </div>
            

            <div class="card-body">

                <x-alert />

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <span class="fw-bold">ID:</span><span> {{ $documento->id }}</span>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <span class="fw-bold">Data da versão:</span><span>
                            {{ \Carbon\Carbon::parse($documento->created_at)->format('d/m/Y') }}</span>
                    </div>

                    <div class="col-12 mb-3">
                        <span> {!! $documento->termos_uso !!}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
