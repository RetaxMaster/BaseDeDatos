<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model {
    protected $fillable = ["linea", "producto", "tipo_doc", "persona", "provincia", "localidad", "domicilio", "cp"];
}
