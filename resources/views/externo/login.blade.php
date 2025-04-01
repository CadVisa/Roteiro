@extends('layouts.layout_1')

@section('content')
    <div class="d-flex justify-content-center align-items-center">
        <div class="card shadow mt-5 col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="card-header text-center bg-primary text-white">
                <div class="mb-0 p-1 h5">Área restrita</div>
            </div>
            <div class="card-body">
                <form action="{{ route('login.process') }}" method="POST" class="row g-3 needs-validation" novalidate>
                    @csrf
                    @method('POST')

                    <x-alert />

                    <div class="col-12">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                            id="email" placeholder="E-mail de usuário"
                            value="{{ old('email', 'vetfacil@hotmail.com') }}" autocomplete="off">
                        <div class="invalid-feedback">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="password" class="form-label">Senha:</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            id="password" placeholder="Senha" value="{{ old('password', '254512') }}" autocomplete="off">
                        <div class="invalid-feedback">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-sm btn-primary">Acessar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
