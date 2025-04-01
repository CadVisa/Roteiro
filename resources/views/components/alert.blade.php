{{-- Mendagem de sucesso --}}
@if (session('success'))
    <div class="alert alert-success d-flex justify-content-center align-items-center alert-dismissible fade show"
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
    <div class="alert alert-danger d-flex justify-content-center align-items-center alert-dismissible fade show"
        role="alert">
        <small class="d-flex align-items-center">
            <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>
            <div>
                {!! session('error') !!}
            </div>
        </small>
    </div>
@endif



