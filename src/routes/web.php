<?php

Route::group(['prefix' => 'yonetim/statistics', 'namespace' => 'berkay\statistics\Http\Controllers'], function () {
    Route::match(['get', 'post'], '/', 'StatisticController@index')->name('yonetim.statistics');







});

