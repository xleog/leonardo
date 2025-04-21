<?php

namespace App\Controllers;

use App\Models\AlmacenModel;
use CodeIgniter\Controller;

class AlmacenController extends Controller
{
    public function almacen_x_suc()
    {
        $AlmacenModel=new AlmacenModel();
        $codsucursal=$this->request->getGet('id');
        $data= $AlmacenModel->get_Almacen_x_suc($codsucursal);
        return $this->response->setJSON([$data]);
    }


}

?>