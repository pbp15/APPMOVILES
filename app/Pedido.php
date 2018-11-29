<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['idcomida','codigo','numero_mesa','cantidad_platos','fecha_hora','condicion'];


 public function comida(){
     return $this->belongsTo('App\Comida');
}
//belongsTo es un metodo
//un pedido pertenece a una comida

}