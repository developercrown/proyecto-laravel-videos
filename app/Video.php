<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    // Uno a Muchos: $this->hasMany('MODELO');
    // Muchos a Uno: $this->belongsTo('MODELO', 'atributo de union');
    // Uno a Uno:: $this->hasOne();

    protected $table = 'videos';

    //Relacion One To Many
    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    //Relacion de Muchos a Uno
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }


}
