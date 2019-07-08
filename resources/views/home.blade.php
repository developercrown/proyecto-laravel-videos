@extends('layouts.app')

@section('content')
<div class="container">
    @yield('headfind')
    <div class="row justify-content-center">
       <div class="container">
           @if(session('message'))
            <div class="alert alert-success">
                {{
                    session('message')
                }}
            </div>
           @endif


            <div class="videos-list">
                @if(count($videos)>=1)
                    @foreach($videos as $video)
                        <div class='video-item col-md-10 mx-auto bg-light mt-2 p-3'>

                            <div class="media">

                                @if(Storage::disk('images')->has($video->image))

                                    <div class="col-md-3">
                                        <img src="{{ url('/miniatura/'.$video->image) }}" alt="thumb" class="img-thumbnail video-image"/>
                                    </div>

                                @else
                                    <p>No image</p>
                                @endif

                                <div class="media-body">

                                    <div class="data">
                                        <h4>
                                        <a href="{{route('detailVideo', ['video_id' => $video->id])}}" class="text-capitalize text-bold">
                                                {{ $video->title }}
                                            </a>
                                        </h4>
                                        <p>
                                            {{ $video->user->name . ' ' . $video->user->surname }}
                                        </p>
                                    </div>

                                    <div class="actions">
                                        {{-- Botones de acción --}}
                                        <a class="btn btn-primary" href="{{route('detailVideo', ['video_id' => $video->id])}}"> Ver </a>

                                        @if(Auth::check() && Auth::user()->id == $video->user->id)
                                            {{-- Seccion del boton editar --}}
                                            <a class="btn btn-warning" href="{{ route('editVideo', $video->id) }}"> Editar </a>

                                            {{-- Seccion de boton eliminar --}}
                                                <a href="#confirmacionEliminarVideo{{$video->id}}" role="button" class="btn btn-large btn-danger" data-toggle="modal">Eliminar</a>

                                                <!-- Modal / Ventana / Overlay en HTML -->
                                                <div id="confirmacionEliminarVideo{{$video->id}}" class="modal fade">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Confirmación</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>¿Estás seguro de eliminar el video?</p>
                                                                <small>
                                                                    <p>
                                                                        {{$video->title}}
                                                                    </p>
                                                                    <p>
                                                                        publicado <i>{{ \FormatTime::LongTimeFilter($video->created_at) }}</i>
                                                                    </p>
                                                                </small>
                                                                <p class="text-danger"><h4>Si lo borras, nunca podrás recuperarlo.</h4></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                <a href="{{ route('videoDelete', $video->id ) }}" type="button" class="btn btn-sm btn-danger">Eliminar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning">No hay videos relacionados a su solicitud</div>
                @endif
            </div>

       </div>

       {{ $videos->links() }}
    </div>
</div>
@endsection
