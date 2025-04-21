<?php 
namespace App\Models;

use CodeIgniter\Model;

class RespondIncideModel extends Model
{
    protected $table      = 'respuestas';
    protected $primaryKey = 'idrespuestas';
    protected $allowedFields = ['idrespuestas','idreclamos','idpersonal','idempresa','respuesta','fecha_respuesta','estado'];

    public function traer_respuestas()
    {
        return $this->select('idrespuestas, idreclamos, idpersonal, idempresa, respuesta, fecha_respuesta, estado')
                    ->orderBy('fecha_respuesta', 'DESC')
                    ->findAll();
    }
    
    public function traer_respuesta_x_cod($cod)
    {
        return $this->select('idreclamos, idpersonal, idempresa, respuesta, fecha_respuesta, estado')
                    ->where('idrespuestas', $cod)
                    ->first();
    }   

    public function ver_articulos_fecha($fini,$ffin,$codempresa)
    {
        $sql = 'CALL REPORTE_RESPUESTAS_EMPRESAS(?, ?, ?)';
        $query = $this->db->query($sql, [
            $fini,
            $ffin,
            $codempresa
        ]);    
        return $query->getResultArray();
    }
}