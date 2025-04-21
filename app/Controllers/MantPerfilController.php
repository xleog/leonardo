<?php 
namespace App\Controllers;
use App\Models\MantPerfilModel;
use CodeIgniter\Controller;

class MantPerfilController extends Controller
{
    public function index()
    {
        return view('Views/Hijos/mant_perfil.php');
    }

    public function traer_perfil()
    {
        $PerfilModel = new MantPerfilModel();
        $data = $PerfilModel->traer_perfil();
        return $this->response->setJSON(['data' => $data]);  
    }

    public function get_datos_x_cod()
    {
        $PerfilModel = new MantPerfilModel();
        $cod = $this->request->getGet('cod');
        $data = $PerfilModel->traer_perfil_x_cod($cod);
        return $this->response->setJSON([$data]);
    }

    public function insertar()
    {
        $model = new MantPerfilModel();
        $descripcion = $this->request->getPost('descripcion');
        $estado = $this->request->getPost('estado');

        if ($model->exists($descripcion)) {
            return $this->response->setJSON(['error' => 'La descripción del perfil ya existe']);
        }

        $data = [
            'descripcion' => $descripcion,
            'estado' => $estado
        ];

        try {
            $model->insert($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Perfil registrado correctamente']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error al registrar el perfil: ' . $e->getMessage()]);
        }
    }

    public function update()
    {
        $model = new MantPerfilModel();
        $id = $this->request->getPost('cod');
        $descripcion = $this->request->getPost('descripcion');
        $estado = $this->request->getPost('estado');

        if ($model->exists($descripcion, $id)) {
            return $this->response->setJSON(['error' => 'La descripción del perfil ya existe']);
        }

        $data = [
            'descripcion' => $descripcion,
            'estado' => $estado
        ];

        try {
            if ($model->update($id, $data)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Perfil actualizado correctamente']);
            } else {
                return $this->response->setJSON(['error' => 'No se encontró el perfil']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error al actualizar el perfil: ' . $e->getMessage()]);
        }
    }
}