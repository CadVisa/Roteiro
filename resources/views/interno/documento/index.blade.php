@extends('layouts.layout_1')

@section('content')

    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-file-lines me-1"></i>Documentos legais</h4>
        </div>

        <div class="card-body">

            <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

                <div
                    class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                    <span>Lista de versões</span>

                    <div>
                        <a href="{{ route('documento.create') }}" class="spinner-light btn btn-sm btn-outline-light">
                            <i class="fa-solid fa-plus"></i>
                            <span class="d-none d-sm-inline"> Adicionar</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <x-alert />

                    @if ($documentos->isEmpty())
                        <div class="alert alert-warning d-flex justify-content-center align-items-center" role="alert">
                            <small class="d-flex align-items-center">
                                <i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;
                                <div>
                                    Nenhum documento cadastrado!
                                </div>
                            </small>
                        </div>
                    @else
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Data da versão</th>
                                    <th class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($documentos as $documento)
                                    <tr>
                                        <td class="text-center">{{ $documento->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($documento->created_at)->format('d/m/Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('documento.showTermos', $documento->id) }}" class="spinner-light btn btn-outline-primary btn-sm"><i
                                                    class="fa-solid fa-file-pen"></i><span class="d-none d-sm-inline">
                                                    Termos</span></a>
                                            <a href="{{ route('documento.showPolitica', $documento->id) }}" class="spinner-light btn btn-outline-primary btn-sm"><i
                                                    class="fa-solid fa-user-lock"></i><span class="d-none d-sm-inline">
                                                    Política</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $documentos->onEachSide(0)->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
