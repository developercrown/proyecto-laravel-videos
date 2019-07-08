{{-- @include('home') //Opcion que solo incluye el contenido --}}

@extends('home')

@section('headfind')
    @if($search != '' && $search != ' ')
        <div class="row">
            <div class="col-sm-12 text-left">
                <h1>Resultados de la busqueda</h1>
                <h4 class="text-muted"><i>{{$search}}</i></h4>
            </div>
        </div>
    @endif
@endsection
