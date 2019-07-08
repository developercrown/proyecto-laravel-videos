@extends('layouts.app')

@section('content')
    <div class="col-md-10 offset-md-1 text-capitalize">
        <h2>{{$video->title}}</h2>
    </div>

    <div class="col-md-8 mx-auto">

        {{-- Video --}}
        <video class="embed-responsive embed-responsive-16by9" id="video-player" controls>
            <source src="{{route('fileVideo', ['filename' => $video->video_path ])}}" />
            Tu navegador no es compatible con HTML5
        </video>

        {{-- Descripcion --}}

        <div class="card mt-1 video-data bg-dark text-light">
            <div class="card-header">
                Subido por <strong>{{$video->user->name . ' ' . $video->user->surname}},  <i>{{ \FormatTime::LongTimeFilter($video->created_at) }}</i></strong>
            </div>
            <div class="card-body">
                {{ $video->description }}
            </div>
        </div>

        {{-- Comentarios --}}

        @include('video.comments')

    </div>
@endsection
