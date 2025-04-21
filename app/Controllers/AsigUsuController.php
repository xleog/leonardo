<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class AsigUsuController extends Controller
{
    public function index()
    {
        return view('Views/Hijos/asignar_usu.php');
    }
}