@extends('layouts.layout_1')

@section('content')
    <div class="d-flex justify-content-center align-items-center">
        <div class="card border-primary border-light shadow col-sm-7 col-md-6 col-lg-5 col-xl-4 col-xxl-3 mt-5">
            <div class="card-header text-center align-items-center border-primary text-light bg-primary">
                <span>Área restrita</span>
            </div>
            <div class="card-body">
                <form action="{{ route('login.process') }}" method="POST" class="row g-3 needs-validation" novalidate>
                    @csrf
                    @method('POST')
                    <x-alert />
                    <div class="col-12">
                        <label for="email" class="form-label mb-1 mandatory">E-mail: </label>
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
                        <label for="password" class="form-label mb-1 mandatory">Senha: </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            id="password" placeholder="Senha" value="{{ old('password', '254512') }}" autocomplete="off">
                        <div class="invalid-feedback">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="spinner-primary btn btn-sm btn-outline-primary">Acessar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
