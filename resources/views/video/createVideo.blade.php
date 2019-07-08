@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-sm-2">
                <h2>Crear un nuevo video</h2>
                <hr />
            <form action="{{ route('saveVideo') }}" method="post" enctype="multipart/form-data"">
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
                        <input type="text" name="title" id="title" class="form-control" placeholder="Titulo del video" value="{{old('title')}}"/>
                    </div>

                    <div class="form-group">
                        <label for="description">Descripcion</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Descripcion del video">{{old('description')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Imagen Miniatura</label>
                        <input type="file" name="image" id="image" class="form-control" placeholder="Imagen Miniatura" value="{{old('image')}}"/>
                    </div>

                    <div class="form-group">
                        <label for="video">Archivo de Video</label>
                        <input type="file" name="video" id="video" class="form-control" placeholder="Archivo de Video" value="{{old('video')}}"/>
                    </div>

                    <button class="btn btn-success">Subir video</button>

                </form>
            </div>
        </div>
    </div>


@endsection
