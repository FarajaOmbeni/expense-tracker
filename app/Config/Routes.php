<?php

use CodeIgniter\Router\RouteCollection;

/*
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->post('/add-expense', 'Home::add_expense');
$routes->post('/add-income', 'Home::add_income');