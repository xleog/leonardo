<?php 
namespace App\Controllers;
use App\Models\MantEmpreModel;
use CodeIgniter\Controller;

class MantEmpresaController extends Controller
{
    public function index()
    {
        return view('Views/Hijos/mant_empresa.php');
    }

    public function traer_empresa()
    {
        $EmpresaModel = new MantEmpreModel();
        $data = $EmpresaModel->traer_empresa();
        return $this->response->setJSON(['data' => $data]);  
    }

    public function get_datos_x_cod()
    {
        $EmpresaModel = new MantEmpreModel();
        $cod = $this->request->getGet('cod');
        $data = $EmpresaModel->traer_empresa_x_cod($cod);
        return $this->response->setJSON([$data]);
    }

    public function insertar()
    {
        $model = new MantEmpreModel();
        $descripcion = $this->request->getPost('descripcion');
        $direccion = $this->request->getPost('direccion');
        $ruc = $this->request->getPost('ruc');
        $estado = $this->request->getPost('estado');

        if ($model->exists($ruc)) {
            return $this->response->setJSON(['error' => 'El RUC de la empresa ya existe']);
        }

        $data = [
            'descripcion' => $descripcion,
            'direccion' => $direccion,
            'ruc' => $ruc,
            'estado' => $estado
        ];

        try {
            $model->insert($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Empresa registrada correctamente']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error al registrar la empresa: ' . $e->getMessage()]);
        }
    }

    public function update()
    {
        $model = new MantEmpreModel();
        $id = $this->request->getPost('cod');
        $descripcion = $this->request->getPost('descripcion');
        $direccion = $this->request->getPost('direccion');
        $ruc = $this->request->getPost('ruc');
        $estado = $this->request->getPost('estado');

        if ($model->exists($ruc, $id)) {
            return $this->response->setJSON(['error' => 'El RUC de la empresa ya existe']);
        }

        $data = [
            'descripcion' => $descripcion,
            'direccion' => $direccion,
            'ruc' => $ruc,
            'estado' => $estado
        ];

        try {
            if ($model->update($id, $data)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Empresa actualizada correctamente']);
            } else {
                return $this->response->setJSON(['error' => 'No se encontró la empresa']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error al actualizar la empresa: ' . $e->getMessage()]);
        }
    }
}