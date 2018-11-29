<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable =  ['nombre','tipo_documento','num_documento','codigo_pedido','email'];
    


public function user(){
    return $this->hasOne('App\User');
    //que una persona esta relacionado directamente con un usuario
}

}