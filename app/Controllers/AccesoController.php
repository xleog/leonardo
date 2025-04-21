<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccesoModel;
use App\Models\AlmacenModel;
use CodeIgniter\HTTP\ResponseInterface;

class AccesoController extends BaseController
{
    public function get_empresas()
    {
        $codigousuario = session()->get('usuario');
        $accesoModel =new AccesoModel();
        $data = $accesoModel->get_empresas($codigousuario);
        return $this->response->setJSON(['success'=>true,'empresas'=>$data]);
    }

    public function get_sucursales(){
        $codigousuario = session()->get('usuario');
        $accesoModel =new AccesoModel();
        $data = $accesoModel->get_sucursales($codigousuario);
        return $this->response->setJSON(['success'=>true,'sucursales'=>$data]);
    }

    public function almacen_x_acceso()
    {
        $AlmacenModel=new AlmacenModel();
        $codsucursal=$this->request->getGet('id');
        $data= $AlmacenModel->get_Almacen_x_suc($codsucursal);
        return $this->response->setJSON(['success'=>true,'almacenes'=>$data]);
    }
}
