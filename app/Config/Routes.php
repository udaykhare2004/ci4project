<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('students', 'Students::index');
$routes->get('students/create', 'Students::create');
$routes->post('students','Students::store');
$routes->get('students/(:num)','Students::show/$1');
$routes->get('students/(:num)/edit','Students::edit/$1');
$routes->post('students/(:num)/edit', 'Students::update/$1');
$routes->post('students/(:num)/delete', 'Students::delete/$1');