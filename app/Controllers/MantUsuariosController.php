<?php
namespace App\Controllers;
use App\Models\MantUsuModel;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class MantUsuariosController extends Controller
{

    public function traer_usuarios()
    {
        $MantUsuModel=new MantUsuModel();
        $data= $MantUsuModel->traer_usuarios();
        return $this->response->setJSON(['data'=>$data]);
    }

    public function index()
    {
        return view("Views/Hijos/mant_usuarios");
    }


    public function traer_datos_x_cod(){
        $MantUsuModel=new MantUsuModel();
        $cod=$this->request->getGet('cod');
        $data=$MantUsuModel->traer_datos_x_cod($cod);
        return $this->response->setJSON($data);
    }

    public function insertar()
    {
        $model = new MantUsuModel();
        $usuario =$this->request->getPost('usuario');
        $estado = $this->request->getPost('estado');
        $clave = $this->request->getPost('clave');
        $perfil = $this->request->getPost('perfil');
        $idusuarios =$this->request->getPost('idusuarios');
        $idpersonal =$this->request->getPost('idpersonal');

        // Verificar si la descripción ya existe
       
        $data = [
            'idusuarios'=>$idusuarios,
            'usuario'=>$usuario,
            'clave'=>$clave,
            'perfil'=>$perfil,
            'estado'=>$estado,
            'idpersonal'=>$idpersonal,

            
        ];

        try {
            // Inserta el Usuarios
            $model->insert($data); // Guarda el Usuario
           
            return $this->response->setJSON(['success' => true, 'message' => 'Usuario Agregado.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Ocurrió un error al agregar el Usuario: ' . $e->getMessage()]);
        }
    }
    public function update()
{
    $model = new UsuarioModel();
        $idusuarios =$this->request->getPost('cod');
        $estado = $this->request->getPost('estado');
        $clave = $this->request->getPost('clave');
        $perfil = $this->request->getPost('perfil');
        $usuario =$this->request->getGet('usuario');
        $data = [
            'usuario'=>$usuario,
            'clave'=>$clave,
            'perfil'=>$perfil,
            'estado'=>$estado,
            'idusuarios'=>$idusuarios
    ];
    

    try {
        // Llama al método de actualización
        if ($model->update($idusuarios, $data)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Usuario actualizado.']);
        } else {
            return $this->response->setJSON(['error' => 'Usuario no encontrado.']);
        }
    } catch (\Exception $e) {
        return $this->response->setJSON(['error' => 'Ocurrió un error al actualizar el Usuario: ' . $e->getMessage()]);
    }

    
}
}

    
