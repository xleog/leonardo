<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AccesoModel;
use App\Models\AlmacenModel;
use CodeIgniter\HTTP\ResponseInterface;

class AccesoController extends BaseController
{
    public function accesoalmacen()
    {
        $usuario = session()->get('usuario');
    
        $empresa = $this->request->getPost('idempresa');
        $sucursal = $this->request->getPost('idsucursal');
        $almacen = $this->request->getPost('idalmacen');
    
        $usuarioModel = new AccesoModel();
        $accessData = $usuarioModel->getAccessData($usuario, $sucursal);
    
        if ($accessData) {
            session()->set([
                'codempresa' => $empresa,
                'codsucursal' => $sucursal,
                'codigoalmacen' => $almacen,
                'empresa'  => $accessData->nempresa,
                'nombrempresa' => $accessData->datempresa,
                'sucursal' => $accessData->descripcion,
                'almacen'  => $accessData->descripcion_alm
            ]);
            log_message('error', 'Sesión después de accesoalmacen: ' . print_r(session()->get(),true));
    
            return redirect()->back(); // Redirige a la página anterior
        } else {
            return $this->response->setJSON(['success' => false, 'mensaje' => 'No se encontró el contexto']);
        }
    }


    public function get_empresas()
    {
        $codigousuario = session()->get('usuario');
        $accesoModel = new AccesoModel();
        $data = $accesoModel->get_empresas($codigousuario);
        return $this->response->setJSON(['success' => true, 'empresas' => $data]);
    }

    public function get_sucursales()
    {
        $codigousuario = session()->get('usuario');
        $idempresa = $this->request->getPost('cod');
        $accesoModel = new AccesoModel();
        $data = $accesoModel->get_sucursales_x_empresa($codigousuario, $idempresa);
        return $this->response->setJSON(['success' => true, 'sucursales' => $data]);
    }

    public function almacen_x_acceso()
    {
        $AlmacenModel = new AlmacenModel();
        $codsucursal = $this->request->getPost('id');
        $data = $AlmacenModel->get_Almacen_x_suc($codsucursal);
        return $this->response->setJSON(['success' => true, 'almacenes' => $data]);
    }
}
