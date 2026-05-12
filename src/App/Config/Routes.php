<?php

declare(strict_types=1);

Namespace App\Config;

use Framework\App;
use App\Controllers\{HomeController,AboutController,AuthController,TransactionController,ReceiptController,ErrorController};
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware};

function registerRoutes(App $app){

    $app->get('/',[HomeController::class,'home'])
        ->add(AuthRequiredMiddleware::class)
    ;

    $app->get('/about',[AboutController::class,'about']);

    $app->get('/register',[AuthController::class,'registerView'])
        ->add(GuestOnlyMiddleware::class)
    ;

    $app->post('/register',[AuthController::class,'register'])
        ->add(GuestOnlyMiddleware::class)
    ;

    $app->get('/login',[AuthController::class,'loginView'])
        ->add(GuestOnlyMiddleware::class)
    ;

    $app->post('/login',[AuthController::class,'login'])
        ->add(GuestOnlyMiddleware::class)
    ;

    $app->get('/logout',[AuthController::class,'logout'])
        ->add(AuthRequiredMiddleware::class)
    ;

    $app->get('/transactions',[TransactionController::class,'createView'])
        ->add(AuthRequiredMiddleware::class);

    $app->post('/transactions',[TransactionController::class,'create'])
        ->add(AuthRequiredMiddleware::class);

    $app->get('transactions/{transaction}',[TransactionController::class,'editView']);

    $app->post('transactions/{transaction}',[TransactionController::class,'edit'])
        ->add(AuthRequiredMiddleware::class);

    $app->delete('transactions/{transaction}',[TransactionController::class,'delete'])
        ->add(AuthRequiredMiddleware::class);

    $app->get('transactions/{transaction}/receipt',[ReceiptController::class,'uploadView'])
        ->add(AuthRequiredMiddleware::class);;

    $app->post('transactions/{transaction}/receipt',[ReceiptController::class,'upload'])
        ->add(AuthRequiredMiddleware::class);

    $app->get('transactions/{transaction}/receipt/{receipt}',[ReceiptController::class,'download'])
        ->add(AuthRequiredMiddleware::class);

    $app->delete('transactions/{transaction}/receipt/{receipt}',[ReceiptController::class,'delete'])
        ->add(AuthRequiredMiddleware::class);

    $app->setErrorHandler([ErrorController::class,'notFound']);
}