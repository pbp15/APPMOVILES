<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nombre','descripcion','condicion'];
    

    public function comidas()
    {
        return $this->hasMany('App\Comida');
    }
    //hasMany-> esto indica q una categoria puede tener varias comidas
}
