<?php

namespace App\Models;
use CodeIgniter\Model;
class ClientesModel extends Model
{
    protected $table      = 'clientes';
    protected $primaryKey = 'idclientes';
    protected $allowedFields = ['idclientes','idtipo_clientes', 'nombre', 'documento', 'direccion', 'fecha_nac', 'nacionalidad', 'estado'];
    public function get_all_clientes()
    {
        return $this ->select('idclientes,documento,nombre,direccion,fecha_nac,nacionalidad,estado')
                     ->orderBy('nombre','ASC')
                     ->findAll();
    }
    public function get_datos_x_cod($cod)
    {
        return $this->select('documento,nombre,direccion,fecha_nac,nacionalidad,estado')
                    ->where('idclientes',$cod)
                    ->first();
    }

    
    public function clientes_activos(){
        return $this->select('idclientes,nombre')
        ->where('estado','ACTIVO')
        ->findAll();
    }

    public function get_activos_dt($searchTerm, $limite, $offset)
    {
        return $this->select("idclientes,nombre,documento")
            ->where('estado', 'ACTIVO')     
            ->like('nombre', $searchTerm)
            ->orderBy('nombre', 'ASC')
            ->limit($limite, $offset)
            ->findAll();
    }

    public function exists($documento, $id = null)
    {
        $query = $this->where('documento', $documento);
        
        // Si se proporciona un ID, excluimos ese registro
        if ($id !== null) {
            $query->where('idclientes !=', $id);
        }

        return $query->first() !== null;
    }

    public function registrar_emailcliente($xmlContent)
    {
        try {
            
            $sql='CALL REG_clientes(?,@mensaje)';
            $this->db->query($sql,[$xmlContent]);

            $result=$this->db->query("SELECT @mensaje as mensaje");
            $mensaje=$result->getRow()->mensaje;

            if(strpos($mensaje,'ERROR:')!==false){
                return $mensaje;
            }
            return $mensaje;

        } catch (\mysqli_sql_exception $e) {
            log_message('error','Error al registrar el email:'.$e->getMessage());
            return 'Error:'.$e->getMessage();
        }    
        catch(\Exception $e){
            log_message('error','Error generico:'.$e->getMessage());
            return 'Error:'.$e->getMessage();
}
}
}
