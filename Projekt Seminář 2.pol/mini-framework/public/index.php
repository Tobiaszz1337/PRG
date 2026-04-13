<?php
/**
 * public/index.php  –  Single entry point
 *
 * Apache / Nginx should route all requests here.
 * See .htaccess for Apache rewrite rules.
 */

require_once dirname(__DIR__) . '/core/bootstrap.php';

// ── Routes ───────────────────────────────────────────────────────────────
$router = new Router();

// Static pages
$router->get('/',         'HomeController',    'index');
$router->get('/home',     'HomeController',    'index');
$router->get('/kontakt',  'ContactController', 'index');
$router->get('/login',    'AuthController',    'loginForm');
$router->post('/login',   'AuthController',    'login');
$router->get('/logout',   'AuthController',    'logout');

// Users CRUD
$router->get('/users',           'UserController', 'index');
$router->get('/users/create',    'UserController', 'create');
$router->post('/users',          'UserController', 'store');
$router->get('/users/:id',       'UserController', 'show');
$router->get('/users/:id/edit',  'UserController', 'edit');
$router->post('/users/:id',      'UserController', 'update');   // _method=PUT via form
$router->delete('/users/:id',    'UserController', 'destroy');  // or POST _method=DELETE

// ── Dispatch ─────────────────────────────────────────────────────────────
$router->dispatch();
