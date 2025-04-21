<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class IncideReportController extends Controller
{
    public function index()
    {
        return view('Views/Hijos/incide_report.php');
    }
}