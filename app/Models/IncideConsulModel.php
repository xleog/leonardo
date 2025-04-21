<?php
namespace App\Models;
use CodeIgniter\Model;

class IncideConsulModel extends Model
{
    protected $table = 'reclamos';
    protected $primaryKey = 'idreclamos';
    protected $allowedFields = ['idreclamos', 'idclientes','idempresa', 'descripcion', 'fecha_reclamo', 'estado'];

    public function traer_incidencias()
    {
        return $this->select('reclamos.idreclamos, reclamos.idclientes, clientes.nombre as nombre_cliente, reclamos.descripcion, reclamos.fecha_reclamo, reclamos.estado')
                    ->join('clientes', 'clientes.idclientes = reclamos.idclientes')
                    ->orderBy('fecha_reclamo', 'DESC')
                    ->findAll();
    }

    public function traer_incidencias_x_cod($cod)
    {
        return $this->select('reclamos.idreclamos, reclamos.idclientes, reclamos.descripcion, reclamos.fecha_reclamo, reclamos.estado, clientes.nombre, clientes.documento')
                    ->join('clientes', 'clientes.idclientes = reclamos.idclientes')
                    ->where('reclamos.idreclamos', $cod)
                    ->first();
    }

    public function ver_articulos_fecha($fini,$ffin,$codempresa)
    {
        $sql = 'CALL REPORTE_RECLAMOS_EMPRESAS(?, ?, ?)';
        $query = $this->db->query($sql, [
            
            $fini,
            $ffin,
            $codempresa
        ]);    
        return $query->getResultArray(); // Retorna los resultados como un array
    }
}

