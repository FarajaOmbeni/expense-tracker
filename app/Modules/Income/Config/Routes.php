<?php

$routes->group(
    'income', ['namespace' => 'App\Modules\Income\Controllers'], function ($routes) {
        $routes->get('/', 'Index::index');
    }
);