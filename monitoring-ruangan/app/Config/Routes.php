<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/','Admin\Dashboard::index');
$routes->get('dashboard','Admin\Dashboard::index');
$routes->get('data-siswa','Siswa::index');
$routes->post('siswa/import','Siswa::simpanExcel');
$routes->get('siswa/export','Siswa::export');
$routes->get('cetakMaster','Siswa::cetakMaster');
$routes->get('kendali','KendaliController::index');
$routes->get('nilai-relay/(:num)','KendaliController::ubah/$1');
$routes->get('uprelay/(:num)' , 'KendaliController::update_relay/$1');

$routes->get('sensor','SensorController::index');
$routes->get('ceksuhu','SensorController::ceksuhu');
$routes->get('cekkelembaban','SensorController::cekkelembaban');
$routes->get('sensor/grafiksuhu','SensorController::getSuhu');

//terima data dari esp
$routes->get(
'terima-data/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)',
'SensorController::update/$1/$2/$3/$4/$5/$6/$7/$8'
);

$routes->get('radio','RadioController::index');
$routes->get('admin/users', 'UserController::index', ['filter' => 'permission:manage-user']);
$routes->get('admin/users', 'UserController::index', ['filter' => 'role:admin,superadmin']);

$routes->get('udara', 'UdaraController::index');
$routes->get('cekgas', 'UdaraController::cekgas');
$routes->get('cekco2', 'UdaraController::cekco2');
$routes->get('cekamonia', 'UdaraController::cekamonia');
$routes->get('cekbenzena', 'UdaraController::cekbenzena');
$routes->get('cekalkohol', 'UdaraController::cekalkohol');
$routes->get('cekasap', 'UdaraController::cekasap');
$routes->get('udara/grafikudara', 'UdaraController::getGas');
$routes->get('api/dashboard-realtime', 'UdaraController::getAllData');

