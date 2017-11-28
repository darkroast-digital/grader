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
$app->post('/results', HomeController::class . ':results')->setName("results");
$app->post('/', HomeController::class . ':post');