<?php 
namespace App\Controllers;
use App\Models\MantPersonalModel;
use CodeIgniter\Controller;
class MantPersonalController extends Controller
{

    public function index()  {
        return view("Views/Hijos/mant_personal");
    }

    public function traer_personal()  {
        $personal=new MantPersonalModel();
        $data=$personal->traer_al_personal();
        return $this->response->setJSON(['data'=>$data]);
    }
    
    public function traer_personal_x_cod() {
        $MantPersonalModel = new MantPersonalModel();
        $cod = $this->request->getGet('cod'); // Asegúrate de que se recibe el código correctamente
        $data = $MantPersonalModel->traer_datos_por_cod($cod);
        return $this->response->setJSON([$data]);
    }    

    public function insertar(){
        $model = new MantPersonalModel();
        $idpersonal = $this->request->getPost('cod');
        $documento_identidad = $this->request->getPost('documento_identidad');
        $estado = $this->request->getPost('estado');
        $nombre = $this->request->getPost('nombre');
        $fecha_nac = $this->request->getPost('fecha_nac');
        $email = $this->request->getPost('email');

        if($model->exists($documento_identidad)){
            return $this->response->setJSON(['error' =>'El documento ingresado ya existe']);
        }

        $data =[
            'nombre'=>$nombre,
            'documento_identidad'=>$documento_identidad,
            'fecha_nac'=>$fecha_nac,
            'estado'=>$estado,
            'email'=>$email,
        ];
        
        try {
            //Inserta el CLiente
            $model->insert($data);
            return $this->response->setJSON(['success'=> true, 'message' =>'Personal Agregado']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error'=> 'Ocurrio un error al agregar el cliente: '. $e->getMessage()]);
        }
    }
    
    public function update() {
        $model = new MantPersonalModel();
        $documento_identidad = $this->request->getPost('documento_identidad');
        $estado = $this->request->getPost('estado');
        $nombre = $this->request->getPost('nombre');
        $fecha_nac = $this->request->getPost('fecha_nac');
        $email = $this->request->getPost('email');
        $idpersonal = $this->request->getPost('cod'); // Obtener ID del artículo a actualizar

        $data =[
            'nombre'=>$nombre,
            'documento_identidad'=>$documento_identidad,
            'fecha_nac'=>$fecha_nac,
            'estado'=>$estado,
            'email'=>$email,
        ];

        try {
            // Llama al método de actualización
            if ($model->update($idpersonal, $data)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Personal actualizado.']);
            } else {
                return $this->response->setJSON(['error' => 'Personal no encontrado.']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Ocurrió un error al actualizar el Personal: ' . $e->getMessage()]);
        }
    
    }


}