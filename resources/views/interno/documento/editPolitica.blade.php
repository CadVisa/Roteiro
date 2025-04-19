@extends('layouts.layout_1')

@section('content')
    <div class="container-fluid">

        <div class="mb-1 space-between-elements text-primary">
            <h4 class="ms-2 mt-3 me-3"><i class="fa-solid fa-file-lines me-1"></i>Documentos legais</h4>
        </div>

        <div class="card border-primary border-ligth shadow mb-3 mt-3 col-md-12">

            <div class="card-header d-flex justify-content-between align-items-center border-primary text-light bg-primary">
                <span>Editar políticas de privacidade</span>
            </div>


            <div class="card-body">

                <x-alert />

                <form action="{{ route('documento.updatePolitica', ['documento' => $documento->id]) }}" method="POST" class="row g-3 needs-validation novalidate">
                    @csrf
                    @method('POST')

                    <div class="col-md-12">
                        <label for="politica_privacidade" class="form-label mb-1 mandatory">Políticas de privacidade: </label>
                        <textarea class="form-control @error('politica_privacidade') is-invalid @enderror" type="text" name="politica_privacidade"
                            id="politica_privacidade" placeholder="Política de privacidade" autocomplete="off">{!! old('politica_privacidade', $documento->politica_privacidade) !!}</textarea>
                        <div class="invalid-feedback">
                            @if ($errors->has('politica_privacidade'))
                                {{ $errors->first('politica_privacidade') }}
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <div>
                            <button class="spinner-success btn btn-outline-success btn-sm" type="submit">
                                <i class="fa-regular fa-floppy-disk"></i> Salvar
                            </button>
                            <a href="{{ route('documento.showPolitica', ['documento' => $documento->id]) }}"
                                class="spinner-danger btn btn-outline-danger btn-sm me-1">
                                <i class="fa-solid fa-xmark"></i> Cancelar
                            </a>
                        </div>
                        <div>
                            <small><span class="text-danger">* Campo obrigatório</span></small>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#politica_privacidade'), {
                toolbar: {
                    items: [
                        'heading', 'bold', 'italic',
                        '|', 'link', 'bulletedList', 'numberedList', 'blockQuote',
                        '|', 'undo', 'redo'
                    ]
                },
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Parágrafo',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Título 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Título 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Título 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Título 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Título 5',
                            class: 'ck-heading_heading5'
                        },
                        {
                            model: 'heading6',
                            view: 'h6',
                            title: 'Título 6',
                            class: 'ck-heading_heading6'
                        }
                    ]
                },
                language: 'pt-br',
            })
            .catch(error => console.error(error));
    </script>
@endsection
