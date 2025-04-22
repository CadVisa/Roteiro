{{-- Mendagem de sucesso --}}
@if (session('success'))
    <div id="alert-success"
        class="alert alert-success d-flex justify-content-center align-items-center alert-dismissible fade show"
        role="alert">
        <small class="d-flex align-items-center">
            <i class="fa-regular fa-circle-check me-2 fs-5"></i>
            <div>
                {!! session('success') !!}
            </div>
        </small>
    </div>
@endif

{{-- Mensagem de erro --}}
@if (session('error'))
    <div id="alert-error"
        class="alert alert-danger d-flex justify-content-center align-items-center alert-dismissible fade show"
        role="alert">
        <small class="d-flex align-items-center">
            <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>
            <div>
                {!! session('error') !!}
            </div>
        </small>
    </div>
@endif

@if (session('success_pdf'))
    <div id="alert-success"
        class="alert alert-success d-flex justify-content-center align-items-center alert-dismissible fade show"
        role="alert">
        <small class="d-flex align-items-center">
            <i class="fa-regular fa-circle-check me-2 fs-5"></i>
            <div>
                {!! session('success_pdf') !!}
            </div>
        </small>
    </div>

    @if (session('pdf_file'))
        <script>
            window.onload = function() {
                const link = document.createElement('a');
                link.href = "{{ route('roteiro.download', ['file' => session('pdf_file')]) }}";
                link.download = "{{ session('pdf_file') }}";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            };
        </script>
    @endif
@endif
