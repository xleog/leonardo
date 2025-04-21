<?php
namespace App\Models;
use CodeIgniter\Model;

class MantUsuModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'idusuarios';
    protected $allowedFields = ['idusuarios','usuario','clave','estado','perfil','password_usu','idpersonal'];
    public function traer_usuarios(){
        return $this ->select('idusuarios,usuario,clave,estado,perfil')
                    ->orderBy('usuario','ASC')
                    ->findAll();
    }
    public function traer_datos_x_cod($cod){
        return $this ->select('idusuarios,usuario,clave,estado,perfil,idpersonal')
                    ->where('idusuarios',$cod)
                    ->first();
    }


  public function exists($usuario, $id = null)
    {
        $query = $this->where('usuario', $usuario);
        
        // Si se proporciona un ID, excluimos ese registro
        if ($id !== null) {
            $query->where('idusuarios !=', $id);
        }

        return $query->first() !== null;
    }
}

