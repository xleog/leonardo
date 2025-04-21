<?php
namespace App\Controllers;
use App\Models\UbigeoModel;
use CodeIgniter\Controller;
use App\Models\ClientesModel;
use XMLWriter;
class ClientesController extends Controller
{
    public function traer_clientes()
    {
        $cliente=new ClientesModel();
        $data=$cliente->get_all_clientes();
        return $this->response->setJSON(['data'=>$data]);
    }
    public function index()
    {
        $UbigeoModel = new UbigeoModel();
        $data['ubigeo'] = $UbigeoModel->ubigeos_departamentos();
        return view('Views/Hijos/clientes', $data);
    }


    public function get_provincia_x_dep(){
        $UbigeoModel=new UbigeoModel();
        $departamento=$this->request->getGet('dep');
        $departamentos=  $UbigeoModel->get_provincia_x_dep($departamento);
        return $this->response->setJSON([$departamentos]);
   }

   public function get_distrito_x_prov_dep(){
        $UbigeoModel = new UbigeoModel();
        $provincia = $this->request->getGet('prov');
        $distritos = $UbigeoModel->get_distrito_x_prov( $provincia);
        return $this->response->setJSON([$distritos]);
    }


    public function get_datos_x_cod()
    {
        $ClienteModel=new ClientesModel();
        $cod=$this->request->getGet('cod');
        $data=$ClienteModel->get_datos_x_cod($cod);
        return $this->response->setJSON([$data]);
    }

    public function insertar()
    {
        $model = new ClientesModel();
        $documento = $this->request->getPost('documento');
        $estado = $this->request->getPost('estado');
        $nombre = $this->request->getPost('nombre');
        $fecha_nac = $this->request->getPost('fecha_nac');
        $nacionalidad = $this->request->getPost('nacionalidad');
        $direccion = $this->request->getPost('direccion');
        $tipo_cliente = $this->request->getPost('tipo_cliente');


        // Verificar si la descripción ya existe
        if ($model->exists($documento)) {
            return $this->response->setJSON(['error' => 'El documento ingresado ya existe.']);
        }

        $data = [
            'idtipo_clientes'=>$tipo_cliente ,
            'nombre'=>$nombre,
            'documento'=>$documento,
            'direccion'=>$direccion,
            'fecha_nac'=>$fecha_nac,
            'nacionalidad'=>$nacionalidad,
            'estado'=>$estado
        ];

        try {
            // Inserta el ciente
            $model->insert($data); // Guarda el cliente 
           
            return $this->response->setJSON(['success' => true, 'message' => 'Cliente Agregado.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Ocurrió un error al agregar el cliente: ' . $e->getMessage()]);
        }
    }

    public function update()
    {
        $model = new ClientesModel();
        $idcliente = $this->request->getPost('cod'); // Obtener ID del artículo a actualizar
        $documento = $this->request->getPost('documento');
        $estado = $this->request->getPost('estado');
        $nombre = $this->request->getPost('nombre');
        $fecha_nac = $this->request->getPost('fecha_nac');
        $nacionalidad = $this->request->getPost('nacionalidad');
        $direccion = $this->request->getPost('direccion');
        $tipo_cliente = $this->request->getPost('tipo_cliente');
        $data = [
            'idtipo_clientes'=>$tipo_cliente ,
            'nombre'=>$nombre,
            'documento'=>$documento,
            'direccion'=>$direccion,
            'fecha_nac'=>$fecha_nac,
            'nacionalidad'=>$nacionalidad,
            'estado'=>$estado
        ];
        

        try {
            // Llama al método de actualización
            if ($model->update($idcliente, $data)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Cliente actualizado.']);
            } else {
                return $this->response->setJSON(['error' => 'Cliente no encontrado.']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Ocurrió un error al actualizar el Cliente: ' . $e->getMessage()]);
        }
    }
        


    public function registrar_emailcliente()
    {

        $data=[
                'Idtipo_Clientes'=>$this->request->getPost('Idtipo_Clientes'),
                'Nombre'=>$this->request->getPost('Nombre'),
                'Estado'=>$this->request->getPost('Documento'),
                'Telefono'=>$this->request->getPost('Codigo_ubigeo'),
                'Email'=>$this->request->getPost('Direccion'),
                'Fecha_nac'=>$this->request->getPost('Fecha_nac'),
                'Usuario'=>$this->request->getPost('Email'),
       
        ];
        $emails=json_decode($this->request->getPost('emails'),true);
        try {
            $MantPersonalModel=new ClientesModel();
            //Generar XML
            $xml=new XMLWriter();
            $xml->openMemory();
            $xml->setIndent(true); 
            $xml->startDocument('1.0','UTF-8');
            $xml->startElement('Clientes');
                $xml->startElement('Cabecera');
                        foreach($data as $key=>$value){
                            $xml->writeElement($key,$value);
                        }
                $xml->endElement(); 
                foreach($emails as $email)
                {
                    $xml->startElement('Email_cliente');
                        foreach($email as $key=>$value){
                            $xml->writeElement($key,$value);
                        }
                    $xml->endElement();
                }
            
                
            $xml->endElement(); 
            $xml->endDocument();
            
            echo $MantPersonalModel->registrar_emailcliente($xml->outputMemory());
        } catch (\Exception $e) {
            echo 'Error:'.$e->getMessage();
        }
}
}


?>
