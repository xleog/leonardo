<?php
namespace App\Models;

use CodeIgniter\Model;

class AlmacenModel extends Model
{
    protected $table      = 'almacen';
    protected $primaryKey = 'idalmacen'; 

    protected $allowedFields = ['idalmacen','descripcion','estado'];

    public function get_Almacen_x_suc($codsucursal){
        return $this->select('idalmacen,descripcion')
                    ->where('estado','ACTIVO')
                    ->where('idsucursal',$codsucursal)
                    ->findAll();
    }
}