<?php

/*
|--------------------------------------------------------------------------
| #WEB
|--------------------------------------------------------------------------
*/



use App\Controllers\HomeController;



// #HOME
// =========================================================================

$app->get('/', HomeController::class . ':index')->setName("home");
$app->get('/bad_request', HomeController::class . ':error400')->setName("error400");
$app->get('/not_found', HomeController::class . ':error404')->setName("error404");
$app->post('/results', HomeController::class . ':results')->setName("results");
$app->post('/', HomeController::class . ':post');