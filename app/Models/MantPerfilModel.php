<?php
namespace App\Models;
use CodeIgniter\Model;

class MantPerfilModel extends Model
{
    protected $table = 'perfil';
    protected $primaryKey = 'idperfil';
    protected $allowedFields = ['idperfil', 'descripcion', 'estado'];
    protected $returnType = 'array';

    public function traer_perfil()
    {
        return $this->select('idperfil, descripcion, estado')
                    ->orderBy('descripcion', 'ASC')
                    ->findAll();
    }
    
    public function traer_perfil_x_cod($cod)
    {
        return $this->select('descripcion, estado')
                    ->where('idperfil', $cod)
                    ->first();
    }   

    public function exists($descripcion, $id = null)
    {
        $query = $this->where('descripcion', $descripcion);
        
        if ($id !== null) {
            $query->where('idperfil !=', $id);
        }
        
        return $query->first() !== null;
    }
}