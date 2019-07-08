<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facedes\DB;

use Illuminate\Support\Facades\Storage;

use Symfony\Component\HttpFoundation\Response;

use App\Video;
use App\Comment;

class VideoController extends Controller
{
    public function createVideo(){
        return view('video.createVideo');
    }

    public function saveVideo(Request $request){
        //Validacion del formulario
        $validateData = $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required|min:5',
            'image' => 'required|mimes:jpg,jpeg,png',
            'video' => 'required|mimes:mp4'
        ]);

        $video = new Video();

        $user = \Auth::user();

        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //Subida de la miniatura

        $image = $request->file('image');

        if($image){
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path;
        }

        //Subida de video

        $video_file = $request->file('video');

        if($video_file){
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path;
        }

        $video->status = "visible";

        $video->save();

        return redirect()->route('home')->with(array(
            'message' => 'El video se ha subido correctamente!!'
        ));

    }

    public function getImage($filename){
        $file = \Storage::disk('images')->get($filename);

        return new Response($file, 200);
    }

    public function getVideoDetail($video_id){
        $video = Video::find($video_id);

        // echo var_dump($video->comments[0]->user->name);

        return view('video.detail', array(
            'video' => $video
        ));
    }

    public function getVideo($filename){
        $file = Storage::disk('videos')->get($filename);
        return new Response($file, 200);
    }

    public function delete($video_id){
        $user = \Auth::user();
        $video = Video::find($video_id);
        $comments = Comment::where('video_id', $video_id)->get(); //Manual
        // $comments = Comment::where('video_id', $video_id);//Automatico

        $message =  'No se realizo ninguna acciòn';

        if($user && $video->user_id == $user->id){

            //Eliminar comentarios
            if($comments && count($comments) >= 1){
                // $comments->delete(); //Modo automatico

                foreach ($comments as $comment) { //Modo manual por iteracion
                    $comment->delete();
                }
            }

            //Elminar ficheros

            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);

            //Eliminar registro
            $video->delete();

            $message =  'Video eliminado correctamente';

        }else{
            $message =  'No se pudo eliminar el video';
        }

        return redirect()->route('home')->with(array(
            'message' => $message
        ));
    }


    public function edit($video_id){
        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        if($user && $video->user_id == $user->id){
            return view('video.edit', array(
                'video' => $video
            ));
        }else{
            return redirect()->route('home')->with(array(
                'message' => 'Acceso denegado'
            ));
        }
    }

    public function update($video_id, Request $request){
        $validateData = $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required|min:5',
            'image' => 'mimes:jpg,jpeg,png',
            'video' => 'mimes:mp4'
        ]);

        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //Subida de la miniatura

        $image = $request->file('image');

        if($image){
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));


            if( \Storage::disk('images')->exists($video->image) ){
                \Storage::disk('images')->delete($video->image);
            }

            $video->image = $image_path;
        }

        //Subida de video

        $video_file = $request->file('video');

        if($video_file){
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));

            if( \Storage::disk('videos')->exists($video->video_path) ){
                \Storage::disk('videos')->delete($video->video_path);
            }

            $video->video_path = $video_path;
        }

        $video->status = "visible";

        $video->update();

        return redirect()->route('home')->with(array(
            'message' => 'Video Actualizado'
        ));
    }

    public function search($search = null){

        if(is_null($search)){
            $search = \Request::get('search'); //Obtenemos el elemento
            if($search == '' || $search == ' '){
                $videos = Video::paginate(5);
                return redirect()->route('home');
            }else{
                return redirect()->route('videoSearch', array(
                    'search' => $search
                ));
            }
        }

        $videos = Video::where('title', 'LIKE', '%'.$search.'%')->paginate(5);
        return view('video.search', array(
            'videos' => $videos,
            'search' => $search
        ));
    }
}
