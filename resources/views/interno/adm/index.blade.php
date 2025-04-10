@extends('layouts.layout_1')

@section('content')
    <div>
        Dashboard

        @if (session('news_contacts') > 0)
            <div class="alert alert-danger" role="alert">
                Você tem {{ session('news_contacts') }} novos contatos para responder.
            </div>            
        @endif
    </div>
@endsection
