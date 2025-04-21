<?php
namespace App\Controllers;

use App\Models\SucursalModel;
use CodeIgniter\Controller;
class SucursalController extends Controller
{
    public function sucursales_x_emp()
    {
        $SucursalModel=new SucursalModel();
        $codempresa=$this->request->getGet('id');
        $data= $SucursalModel->get_sucursales_x_emp($codempresa);
        return $this->response->setJSON([$data]);
    }
}
?>