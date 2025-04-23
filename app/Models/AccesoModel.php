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

    public function get_sucursales_x_empresa($codigousuario, $idempresa) {
        return $this->distinct()
        ->select('suc.idsucursal, suc.descripcion')
        ->join('sucursal suc','acc.idsucursal = suc.idsucursal')
        ->where('acc.acceso','SI')
        ->where('acc.idusuarios', $codigousuario)
        ->where('suc.idempresa', $idempresa)
        ->where('suc.estado', 'ACTIVO')
        ->findAll();
    }


    public function getAccessData($codusuario, $sucursal)
    {
        return $this->select('acc.idusuarios codusu,usu.usuario AS nombre,sucu.descripcion,alm.descripcion descripcion_alm,
                emp.descripcion nempresa,emp.venc_crt,CONCAT(emp.descripcion,"-",emp.ruc)datempresa,emp.ruc,emp.direccion dir_empresa,
                emp.usuario_sol,emp.clavesol,usu.perfil AS perfil,emp.ubigeo,emp.modo_ft_notas,emp.modo_guias,emp.clientid,emp.passid')
            ->join('usuarios usu', 'acc.idusuarios = usu.idusuarios')
            ->join('sucursal sucu', 'acc.idsucursal = sucu.idsucursal')
            ->join('empresa emp', 'emp.idempresa = sucu.idempresa')
            ->join('almacen alm', 'sucu.idsucursal = alm.idsucursal')
            ->where('acceso', 'SI')
            ->where('acc.idusuarios', $codusuario)
            ->where('acc.idsucursal', $sucursal)
            ->get()
            ->getRow();
    }
}