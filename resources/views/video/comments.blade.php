<hr/>
<h4>Comentarios</h4>
<hr/>
@if(session('message'))
    <div class="alert alert-success">
        {{
            session('message')
        }}
    </div>
@endif

@if(Auth::check())
    <form action="{{ route('comment') }}" method="POST" class="col-md-10 offset-sm-1 mt-2 mb-4">
        {!! csrf_field() !!}


        <textarea class="form-control my-2" name="body" style="height: 80px;resize: none;outline: none; box-shadows: none;" required></textarea>

        <input type="hidden" class="form-control" name="video_id" value="{{$video->id}}" required />
        <button type="submit" class="btn btn-success" >Comentar</button>

    </form>
@endif

@if(isset($video->comments))
    <div class="comments-list">
        @foreach ($video->comments as $comment)
            <div class="comment-item col-md-12 pull-left my-1">
                <div class="card comment-data">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8 text-left">
                                Publicado por <b>{{ $comment->user->name }}</b>
                            </div>
                            <div class="col-sm-4 text-right">
                                <i>{{ \FormatTime::LongTimeFilter($comment->created_at) }}</i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-text pl-3">
                            <div class="row">

                                <div class="col-sm-9">
                                    {{ $comment->body }}
                                </div>
                                @if(\Auth::check() && (\Auth::user()->id == $comment->user_id || \Auth::user()->id == $video->user_id) )
                                    <div class="col-sm-3">
                                        <div class="row text-center d-flex flex-row justify-content-end align-items-center m-0 p-0">
                                            <div class="col-sm-6 float-right">

                                                {{-- Botón en HTML (lanza el modal en Bootstrap) --}}

                                                <a href="#confirmacionEliminar{{$comment->id}}" role="button" class="btn btn-large btn-danger" data-toggle="modal">Eliminar</a>

                                                <!-- Modal / Ventana / Overlay en HTML -->
                                                <div id="confirmacionEliminar{{$comment->id}}" class="modal fade">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Confirmación</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>¿Estás seguro de eliminar el comentario?</p>
                                                                <small>
                                                                    <p>
                                                                        {{$comment->body}}
                                                                    </p>
                                                                    <p>
                                                                        publicado <i>{{ \FormatTime::LongTimeFilter($comment->created_at) }}</i>
                                                                    </p>
                                                                </small>
                                                                <p class="text-danger"><h4>Si lo borras, nunca podrás recuperarlo.</h4></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                <a href="{{ route('commentDelete', $comment->id ) }}" type="button" class="btn btn-sm btn-danger">Eliminar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{--  --}}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
