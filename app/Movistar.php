<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movistar extends Model {
    protected $fillable = ["idcontrato", "imei", "tipodoc", "persona", "cuil", "sexo", "idcliente", "alias", "telefono", "rol", "tipo", "movil", "estado", "direccion", "localidad", "provincia", "cp", "cpa"];
    
}
