<?php

use App\Controllers\LoginController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->post('/conversor','Home::conversor');
$routes->get('/conf_perfil','PerfilController::conf_perfil');
$routes->get('/registro','RegistroController::registro');
$routes->get('/selector','UsuMantController::traer_usuarios');

$routes->group('login',function($routes){
    $routes->get('/', 'LoginController::login');
    $routes->get('select_suc','SucursalController::sucursales_x_emp');
    $routes->get('select_alm','AlmacenController::almacen_x_suc');
    $routes->post('ingresar', 'LoginController::logueo_ingreso');
    $routes->get('salir', 'LoginController::salir');
});

$routes->group('',['filter'=>'AuthFilter'], function($routes){
    $routes->get('/', 'Home::index');
    $routes->get('/usuario','UsuarioController::index');
    $routes->get('dashboard', 'Home::index');
    $routes->get('conf', 'MantUsuariosController::index');

});


$routes->group('conf',['filter'=>'AuthFilter'], function($routes){

    $routes->get('mant_usuarios', 'MantUsuariosController::index');
    $routes->get('mant_empresa', 'MantEmpresaController::index');
    $routes->get('mant_perfil', 'MantPerfilController::index');
    $routes->get('mant_personal', 'MantPersonalController::index');
    $routes->get('clientes', 'ClientesController::index');

});

$routes->group('incide',['filter'=>'AuthFilter'], function($routes){

    $routes->get('incide_consul', 'IncideConsulController::index');
    $routes->get('incide_report', 'IncideReportController::index');

});

$routes->group('asig',['filter'=>'AuthFilter'], function($routes){

    $routes->get('asignar_usu', 'AsigUsuController::index');
    $routes->get('respond_incide', 'RespondIncideController::index');

});

$routes->group('datatables',['filter'=>'CambioFilter'],function($routes){
    $routes->get('dtusuarios','MantUsuariosController::traer_usuarios');
    $routes->get('dtpersonal','MantPersonalController::traer_personal');
    $routes->get('dtempresa','MantEmpresaController::traer_empresa');
    $routes->get('dtclientes','ClientesController::traer_clientes');
    $routes->get('dtperfil','MantPerfilController::traer_perfil');
    $routes->get('dtincideconsul','IncideConsulController::traer_incidencias');
    $routes->get('dtrespuestas','RespondIncideController::traer_respuestas');
});

$routes->group('devdat',['filter'=>'CambioFilter'],function($routes){
    $routes->get('usuarios','MantUsuariosController::traer_datos_x_cod');
    $routes->get('personal','MantPersonalController::traer_personal_x_cod');
    $routes->get('empresas','MantEmpresaController::get_datos_x_cod');
    $routes->get('clientes','ClientesController::get_datos_x_cod');
    $routes->get('perfiles','MantPerfilController::get_datos_x_cod');
    $routes->get('respuestas','RespondIncideController::get_datos_x_cod');
    $routes->get('incideconsul','IncideConsulController::get_datos_x_cod');
});

$routes->group('incidencias',['filter'=>'CambioFilter'],function($routes){  
    $routes->post('registrar','IncideConsulController::insertar');
    $routes->post('editar','IncideConsulController::update');
    $routes->get('obtener_clientes','IncideConsulController::obtener_clientes');
    $routes->get('busc_clientes','IncideConsulController::busc_clientes');
});

$routes->group('perfil',['filter'=>'CambioFilter'],function($routes){  
    $routes->post('registrar','MantPerfilController::insertar');
    $routes->post('editar','MantPerfilController::update');
});

$routes->group('usuarios',['filter'=>'CambioFilter'],function($routes){
    $routes->post('registrar','MantUsuariosController::insertar');
    $routes->post('editar','MantUsuariosController::update');
});

$routes->group('respuestas',['filter'=>'CambioFilter'],function($routes){
    $routes->post('registrar','RespondIncideController::insertar');
    $routes->post('editar','RespondIncideController::update');
});

$routes->group('personal',['filter'=>'CambioFilter'],function($routes){
    $routes->post('registrar','MantPersonalController::insertar');
    $routes->post('editar','MantPersonalController::update');
    $routes->get('reniec','ApiController::buscar_DNI');
});

$routes->group('empresa',['filter'=>'CambioFilter'],function($routes){
    $routes->post('registrar','MantEmpresaController::insertar');
    $routes->post('editar','MantEmpresaController::update');
    $routes->get('sunat','ApiController::buscar_RUC');
});

$routes->group('clientes',['filter'=>'CambioFilter'],function($routes){
    $routes->post('registrar','ClientesController::insertar');
    $routes->post('editar','ClientesController::update');
    $routes->get('cmbprovincia','ClientesController::get_provincia_x_dep');
    $routes->get('cmbdistrito','ClientesController::get_distrito_x_prov_dep');
    $routes->get('sunat','ApiController::buscar_RUC');
    $routes->get('reniec','ApiController::buscar_DNI');
    $routes->get('busc_clientes', 'Clientes::busc_clientes');
});

$routes->group('report',['filter'=>'CambioFilter'],function($routes){
    $routes->post('rtpincide','IncideConsulController::rptgeneral');
    $routes->post('rptrespuestas','RespondIncideController::rptgeneral');
    $routes->post('rtpincideindividual','IncideConsulController::rptindividual');

});

$routes->group('cambio',['filter'=>'CambioFilter'],function($routes){
    $routes->post('empresa','AccesoController::get_empresas');
    $routes->post('sucursal','AccesoController::get_sucursales');
    $routes->post('almacen', 'AccesoController::almacen_x_acceso');
    $routes->post('ingresar','AccesoController::accesoalmacen');
});

