<?php
namespace App\Models;

use CodeIgniter\Model;

class SucursalModel extends Model
{
    protected $table      = 'sucursal';
    protected $primaryKey = 'idsucursal';
    protected $allowedFields = ['idsucursal','descripcion','estado'];

    public function get_sucursales_x_emp($codempresa) {
        return $this ->select('idsucursal,descripcion,estado')        
                    ->where('estado','ACTIVO')
                    ->where('idempresa',$codempresa)
                    ->findAll();
    }
}
?>