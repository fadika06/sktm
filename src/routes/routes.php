<?php

Route::group(['prefix' => 'api/master-sktm', 'middleware' => ['web']], function() {
    $class          = 'Bantenprov\Sktm\Http\Controllers\MasterSktmController';
    $name           = 'master-sktm';
    $controllers    = (object) [
        'index'     => $class.'@index',
        'get'       => $class.'@get',
        'create'    => $class.'@create',
        'show'      => $class.'@show',
        'store'     => $class.'@store',
        'edit'      => $class.'@edit',
        'update'    => $class.'@update',
        'destroy'   => $class.'@destroy',
    ];

    Route::get('/',             $controllers->index)->name($name.'.index');
    Route::get('/get',          $controllers->get)->name($name.'.get');
    Route::get('/create',       $controllers->create)->name($name.'.create');
    Route::get('/{id}',         $controllers->show)->name($name.'.show');
    Route::post('/',            $controllers->store)->name($name.'.store');
    Route::get('/{id}/edit',    $controllers->edit)->name($name.'.edit');
    Route::put('/{id}',         $controllers->update)->name($name.'.update');
    Route::delete('/{id}',      $controllers->destroy)->name($name.'.destroy');
});

Route::group(['prefix' => 'api/sktm', 'middleware' => ['web']], function() {
    $class          = 'Bantenprov\Sktm\Http\Controllers\SktmController';
    $name           = 'sktm';
    $controllers    = (object) [
        'index'     => $class.'@index',
        'get'       => $class.'@get',
        'create'    => $class.'@create',
        'show'      => $class.'@show',
        'store'     => $class.'@store',
        'edit'      => $class.'@edit',
        'update'    => $class.'@update',
        'destroy'   => $class.'@destroy',
    ];

    Route::get('/',             $controllers->index)->name($name.'.index');
    Route::get('/get',          $controllers->get)->name($name.'.get');
    Route::get('/create',       $controllers->create)->name($name.'.create');
    Route::get('/{id}',         $controllers->show)->name($name.'.show');
    Route::post('/',            $controllers->store)->name($name.'.store');
    Route::get('/{id}/edit',    $controllers->edit)->name($name.'.edit');
    Route::put('/{id}',         $controllers->update)->name($name.'.update');
    Route::delete('/{id}',      $controllers->destroy)->name($name.'.destroy');
});
