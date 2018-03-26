<?php

Route::group(['prefix' => 'api/sktm', 'middleware' => ['web']], function() {
    $controllers = (object) [
        'index'     => 'Bantenprov\Sktm\Http\Controllers\SktmController@index',
        'create'    => 'Bantenprov\Sktm\Http\Controllers\SktmController@create',
        'show'      => 'Bantenprov\Sktm\Http\Controllers\SktmController@show',
        'store'     => 'Bantenprov\Sktm\Http\Controllers\SktmController@store',
        'edit'      => 'Bantenprov\Sktm\Http\Controllers\SktmController@edit',
        'update'    => 'Bantenprov\Sktm\Http\Controllers\SktmController@update',
        'destroy'   => 'Bantenprov\Sktm\Http\Controllers\SktmController@destroy',
    ];

    Route::get('/',             $controllers->index)->name('sktm.index');
    Route::get('/create',       $controllers->create)->name('sktm.create');
    Route::get('/{id}',         $controllers->show)->name('sktm.show');
    Route::post('/',            $controllers->store)->name('sktm.store');
    Route::get('/{id}/edit',    $controllers->edit)->name('sktm.edit');
    Route::put('/{id}',         $controllers->update)->name('sktm.update');
    Route::delete('/{id}',      $controllers->destroy)->name('sktm.destroy');
});
