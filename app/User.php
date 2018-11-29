<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','usuario','password', 'condicion', 'idrol'
    ];
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //la variable $hidden es para ocultar el password
    public function rol(){
        return $this->belongsTo('App\Rol');
        //que un usuario pertenece a un rol
    }

    public function persona(){
        return $this->belongsTo('App\Persona');
        // un usuario hace referencia a una persona
    }





}
