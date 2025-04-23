<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;
use App\Models\EmpresaModel;
use App\Models\BarrasPerfilModel;
use App\Models\AlmacenModel;
use App\Models\SucursalModel;

class LoginController extends Controller
{
    public function login()
    {
        $usuario = new UsuarioModel();
        $empresa = new EmpresaModel();
        $data['usuarios'] = $usuario->usuarios_activos();
        $data['empresa'] = $empresa->empresas_activas();

        return view('login/login', $data);
    }

    public function unauthorized()
    {
        return view('unauthorized.php');
    }
    public function salir()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

    public function logueo_ingreso()
    {

        //$actual = date("Y-m-d");
        $clave = $this->request->getPost('pssw');
       // $empresa = $this->request->getPost('idemp');
      //  $sucursal = $this->request->getPost('idsu');
       // $almacen = $this->request->getPost('idalm');
        $usuario = $this->request->getPost('idusu');
        try {
            $usuarioModel = new UsuarioModel();
            $barrasperfilModel = new BarrasPerfilModel();
            // Verifica el usuario y la contraseña
            $userData = $usuarioModel->getUser($usuario, $clave); // Implementa este método en tu modelo
            
           // log_message('error', 'Datos recibidos: ' . json_encode($userData));

            if ($userData) {
                // Si se encontró el usuario, verifica el acceso
            
                $accessData = $usuarioModel->getAccessData($usuario ); // Implementa este método en tu modelo
                //log_message('error', 'Datos recibidos: ' . json_encode($accessData));
                $url_x_perfil = $barrasperfilModel->geturlsxperfil_aside($accessData->perfil);

                if ($accessData) {
  
                        //log_message('error','Entro aqui');
                        // Almacena en sesión los datos necesarios
                        session()->set([
                           //  'codempresa' => $empresa,
                           //'rucempresa' => $accessData->ruc,
                          //  'codsucursal' => $sucursal,
                          //  'nombresucursal' => $accessData->descripcion,
                          //  'nombrealmacen' => $accessData->descripcion_alm, 
                            'nombreusuario' => $accessData->nombre,
                            'nombreusuariocorto' => $userData['usuario'],
                            //'nombrempresa' => $accessData->datempresa,
                           // 'ubigeoempresa' => $accessData->ubigeo,
                           // 'nempresa' => $accessData->nempresa,
                           // 'dirempresa' => $accessData->dir_empresa,
                           // 'usol' => $accessData->usuario_sol,
                           // 'clavesol' => $accessData->clavesol, 
                            'usuario' => $userData['idusuarios'],
                          //  'codigoalmacen' => $almacen,
                            'password' => $clave,
                            'perfil' => $accessData->perfil,                           
                           // 'n_empresa' => $accessData->nempresa,
                          //  'modofe' => $accessData->modo_ft_notas,
                          //  'modoguias' => $accessData->modo_guias,
                          //  'clientid' => $accessData->clientid,
                         //   'passid' => $accessData->passid, 
                            'urls' => $url_x_perfil,
                            'is_logged' => true
                        ]);

                        return $this->response->setJSON([
                            'success' => true
                        ]);
                    }
                
            
                 } else {
                return $this->response->setJSON([
                    'success' => false,
                    'mensaje' => 'Usuario o Clave Incorrecto'
                ]);
            }
        
    
        } catch (\Exception $e) {
            return json_encode(['error' => ['text' => $e->getMessage()]]);
        }
    }

    public function cambio_almacen()
    {

        $session = session();

        if ($session->get('nombreusuario')) {
            $idsucursal = $this->request->getPost('cmbsucursal');
            $idalmacen = $this->request->getPost('cmbalmacen');

            $session->set('codsucursal', $idsucursal);
            $session->set('codigoalmacen', $idalmacen);

            $almacenModel = new AlmacenModel();
            $sucursalModel = new SucursalModel();

            // Obtener información del almacén
            $nombalmacen = $almacenModel->getAlmacen($idalmacen);

            $nombalmacen = $nombalmacen ? $nombalmacen['descripcion'] : '';

            // Obtener información de la sucursal
            $data = $sucursalModel->getSucursalData($idsucursal);

            if ($data) {
                $session->set([
                    'nombresucursal' => $data->descripcion,
                    'nombrempresa' => $data->descripcion, // Asegúrate de que este sea el campo correcto
                    'nempresa' => $data->descripcion,
                    'nombrealmacen' => $nombalmacen,
                    'dirempresa' => $data->direccion,
                    'rucempresa' => $data->ruc,
                    'codempresa' => $data->idempresa,
                    'modofe' => $data->modo_ft_notas,
                    'modoguias' => $data->modo_guias,
                    'usol' => $data->usuario_sol,
                    'clavesol' => $data->clavesol,
                    'clientid' => $data->clientid,
                    'passid' => $data->passid,
                ]);
            }

            return redirect()->back(); // Redirige a la página anterior
        } else {
            return redirect()->to('login');
        }
    }
}
