<?php 

namespace App\Models;

use CodeIgniter\Model;

class UbigeoModel extends Model
{
    protected $table      = 'ubigeo';
    protected $primaryKey = 'idubigeo';

    protected $allowedFields = ['idubigeo', 'codigo_ubigeo', 'departamento', 'provincia', 'distrito'];

    public function ubigeos_departamentos(){
        return $this->select('idubigeo, codigo_ubigeo, departamento')
                    ->orderBy('departamento', 'ASC')
                    ->where('distrito','D')
                    ->findAll();
    }
    public function get_provincia_x_dep($departamento){
        return $this->select('provincia, distrito')
                    ->orderBy('departamento', 'ASC')
                    ->where('distrito','P')
                    ->where('departamento',$departamento)
                    ->findAll();
    }

    public function get_distrito_x_prov( $provincia){
        return $this->select('distrito, codigo_ubigeo')
                    ->where('provincia', $provincia)
                    ->whereNotIn('distrito', ['P'])
                    ->orderBy('distrito', 'ASC')
                    ->findAll();
    }

}

?>