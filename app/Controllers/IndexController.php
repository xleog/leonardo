<?php
namespace App\Controllers;
use CodeIgniter\Controller;
class IndexController extends Controller
{
    public function index()
    {
        return view("index/index");
    }
}
?>