<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ObrasSociales extends Model {
    protected $fillable = ["persona", "CuilTitular", "CuilTitularCodOS", "CuilTitularOS", "PeriodoDesde", "CuilTitularSexo", "CuilTitularFechaNacimiento", "CuilTitularCalle", "CuilTitularNro", "CuilTitularPiso", "CuilTitularDpto", "CuilTitularCodPostal", "CuilTitularLocalidad", "CuilTitularPcia", "CuilRelacionado", "Relacion", "CuilRelacionadoApeNom", "CuilRelacionadoSexo", "CuilRelacionadoFechaNacimiento", "CuilRelacionadoCalle", "CuilRelacionadoNro", "CuilRelacionadoPiso", "CuilRelacionadoDepto", "CuilRelacionadoCodPostal", "CuilRelacionadoLocalidad", "CuilRelacionadoPcia", "CuilTitularTEL", "CuilRelacionadoTEL"];    

    public static function truncate() {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0;");
        DB::table("obras_sociales")->truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS = 1;");
    }

    // Relaciones
    
    public function personinfo() {
        return $this->belongsTo(Personas::class, 'persona');
    }
    
    // -> Relaciones
}
