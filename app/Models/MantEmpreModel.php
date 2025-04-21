<?php 
namespace App\Models;

use CodeIgniter\Model;

class MantEmpreModel extends Model
{
    protected $table = 'empresa';
    protected $primaryKey = 'idempresa';
    protected $allowedFields = ['idempresa', 'descripcion', 'direccion', 'ruc', 'estado'];
    protected $returnType = 'array';

    public function traer_empresa()
    {
        return $this->select('idempresa, descripcion, direccion, ruc, estado')
                    ->orderBy('descripcion', 'ASC')
                    ->findAll();
    }
    
    public function traer_empresa_x_cod($cod)
    {
        return $this->select('descripcion, direccion, ruc, estado')
                    ->where('idempresa', $cod)
                    ->first();
    }   

    public function exists($ruc, $id = null)
    {
        $query = $this->where('ruc', $ruc);
        
        if ($id !== null) {
            $query->where('idempresa !=', $id);
        }
        
        return $query->first() !== null;
    }
}