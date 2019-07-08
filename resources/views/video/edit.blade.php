@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-sm-2">
                <h2>Editar el video</h2>
                <hr />
            <form action="{{ route('updateVideo', $video->id) }}" method="post" enctype="multipart/form-data"">
                    {!! csrf_field() !!}

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>
                                        {{
                                            $error
                                        }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="title">Titulo</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Titulo del video" value="{{$video->title}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">Descripcion</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Descripcion del video">{{$video->description}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Imagen Miniatura</label>
                        @if(Storage::disk('images')->has($video->image))

                            <div class="col-md-3">
                                <img src="{{ url('/miniatura/'.$video->image) }}" alt="thumb" class="img-thumbnail video-image"/>
                            </div>

                        @else
                            <p>No image</p>
                        @endif
                        <input type="file" name="image" id="image" class="form-control" placeholder="Imagen Miniatura" value="{{$video->image}}"/>
                    </div>

                    <div class="form-group">
                        <label for="video">Archivo de Video</label>
                        <video class="embed-responsive embed-responsive-16by9" id="video-player" controls>
                            <source src="{{route('fileVideo', ['filename' => $video->video_path ])}}" />
                            Tu navegador no es compatible con HTML5
                        </video>
                        <input type="file" name="video" id="video" class="form-control" placeholder="Archivo de Video" value="{{$video->video_path}}"/>
                    </div>

                    <button class="btn btn-warning m-auto">Actualizar video</button>

                </form>
            </div>
        </div>
    </div>


@endsection
