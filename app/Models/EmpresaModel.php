<?php
namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table      = 'empresa';
    protected $primaryKey = 'idempresa';
    protected $allowedFields = ['idempresa','ruc','descripcion'];

    public function empresas_activas() {
        return $this ->select('idempresa,ruc,descripcion')
                    ->where('estado','ACTIVO')
                    ->findAll();
    }
}
?>