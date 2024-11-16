@extends('layouts.index')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">

            @include('top_bar')

            <div class="col card p-5 text-center">
                <span class="display-3 mb-5"><i class="fa-solid fa-triangle-exclamation text-warning opacity-50"></i></span>
                <h4 class="text-info mb-3">{{ $note->title }}</h4>
                <p class="text-secondary">Você tem certeza que deseja remover essa nota?</p>
                <div class="mt-3">
                    <a href="{{ route('home') }}" class="btn btn-primary px-5 m-2"><i class="fa-solid fa-xmark me-2"></i>Não</a>
                    <a href="{{ route('deleteConfirm', ['id' => Crypt::encrypt($note->id)]) }}" class="btn btn-danger px-5 m-2"><i class="fa-solid fa-trash me-2"></i>Sim</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection