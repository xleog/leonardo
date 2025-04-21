<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'idusuarios';
    protected $allowedFields = ['idusuarios','usuario', 'password_usu'];
    public function usuarios_activos()
    {
        return $this->select('idusuarios,usuario,password_usu')
                    ->where('estado', 'ACTIVO')
                    ->findAll();
    }

    public function getAccessData($codusuario)
    {

        return $this->db->table('acceso ace')
            ->select('ace.idusuarios codusu,usu.usuario AS nombre,usu.perfil AS perfil,usu.idusuarios')
            ->join('usuarios usu', 'ace.idusuarios = usu.idusuarios')
            ->where('acceso', 'SI')
            ->where('ace.idusuarios', $codusuario)
            ->get()
            ->getRow();
    }

    public function getUser($usuario, $clave)
    {
        // Obtener el usuario desde la base de datos
        $user = $this->where('idusuarios', $usuario)
                     ->where('estado', 'ACTIVO')
                     ->first();        
    
        // Verificar si el usuario fue encontrado
        if ($user) {
           
            $passwordCheck = password_verify($clave, $user['password_usu']);            
                
            if ($passwordCheck) {
                return $user; // La contraseña es correcta
            }
        }        
        
        return null; // Usuario desactivado o contraseña incorrecta
    }
}