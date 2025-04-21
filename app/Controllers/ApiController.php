<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class ApiController extends Controller
{
    private $token;
    public function __construct()
    {
        $this->token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIzNjEiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3JvbGUiOiJjb25zdWx0b3IifQ.B81DoiOtetzqp491Ihi0hpwnBFUWGAZNJC2ZMFrVRyg';
    }

    public function buscar_DNI(){
        $dni=$this->request->getGet('doc');
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.factiliza.com/v1/dni/info/".$dni,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer ".$this->token
        ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        // Procesar respuesta
        $persona = json_decode($response);

        if ($persona->status != "200") {
            return $this->response->setJSON(['error' => 'NO ENCONTRADO'])->setStatusCode(404);
        } else {
            return $this->response->setJSON($persona->data);
        }
                
    }

    public function buscar_RUC(){
        $ruc=$this->request->getGet('ruc');
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.factiliza.com/v1/ruc/info/".$ruc,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
              "Authorization: Bearer ".$this->token
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        // Procesar respuesta
        $persona = json_decode($response);

        if ($persona->status != "200") {
            return $this->response->setJSON(['error' => 'NO ENCONTRADO'])->setStatusCode(404);
        } else {
            return $this->response->setJSON($persona->data);
        }
                
    }
}
