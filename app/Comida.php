<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comida extends Model
{

    protected $fillable = ['idcategoria','nombre','precio_venta','imagen','descripcion','condicion'];


 public function categoria(){
     return $this->belongsTo('App\Categoria');
}


//belongsTo es un metodo
//una comida pertenece a una categoria

public function pedidos()
{
    return $this->hasMany('App\Pedido');
}
 //hasMany-> esto indica q una comida puede tener varios pedidos

}