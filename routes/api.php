<?php

use App\Http\Controllers\EmployeeAttendanceController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('/v1')->group(function(){


    Route::prefix('/orders')->group(function(){

        Route::get('/current' , [OrderController::class , 'current']);
        Route::get('/stopped' , [OrderController::class , 'stopped']);
        Route::get('/finished' , [OrderController::class , 'finished']);
        Route::get('/archived' , [OrderController::class , 'archived']);

        Route::post('/store' , [OrderController::class , 'store']);

        Route::post('/update/{order}' , [OrderController::class , 'update']);

        Route::post('/update/notes/{order}' , [OrderController::class , 'updateNotes']);
        Route::post('/update/problems/{order}' , [OrderController::class , 'updateProblems']);

        Route::post('/update/pdf/{order}' , [OrderController::class , 'updatePdf']);
        Route::post('/update/dxf/{order}' , [OrderController::class , 'updateDxf']);

        Route::post('/update/done/{order}' , [OrderController::class , 'updateDone']);
        Route::post('/update/shipped/{order}' , [OrderController::class , 'updateShipped']);

        Route::get('/finish/{order}' , [OrderController::class , 'finish']);
        Route::get('/start/{order}' , [OrderController::class , 'start']);
        Route::get('/stop/{order}' , [OrderController::class , 'stop']);
        Route::get('/archive/{order}' , [OrderController::class , 'archive']);
        Route::get('/unarchive/{order}' , [OrderController::class , 'unarchive']);

        Route::get('/delete/{order}' , [OrderController::class , 'destroy']);

    });

});
