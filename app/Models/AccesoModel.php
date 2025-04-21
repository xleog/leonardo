<?php

namespace App\Models;

use CodeIgniter\Model;

class AccesoModel extends Model
{
    protected $table            = 'acceso acc';
    protected $primaryKey       = 'idacceso';

    protected $allowedFields    = ['idacceso',
        'idusuarios',
        'idsucursal',
        'acceso'];
    
    public function get_empresas($codigousuario)  {
        return $this->distinct()
        ->select('emp.idempresa, emp.descripcion')
        ->join('sucursal suc','acc.idsucursal = suc.idsucursal')
        ->join('empresa emp','suc.idempresa = emp.idempresa')
        ->where('acc.acceso','SI')
        ->where('acc.idusuarios', $codigousuario)
        ->findAll();
    }

    public function get_sucursales($codigousuario) {
        return $this->distinct()
        ->select('suc.idsucursal, suc.descripcion')
        ->join('sucursal suc','acc.idsucursal = suc.idsucursal')
        ->where('acc.acceso','SI')
        ->where('acc.idusuarios', $codigousuario)
        ->findAll();
    }

    
}