<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\DomCrawler\Crawler;

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

Route::prefix('{server}')->group(function () {

    // Economy
    Route::get('/product/{resource}/{country}/{quality}', 'API\EconomyController@getProducts');
    Route::get('/exchange/{from}/{to}', 'API\EconomyController@getExchange');
    Route::get('/jobs/{country}/{skill}', 'API\EconomyController@getJobs');
    Route::get('/auctions/{status}/{sorting}/{page}', 'API\EconomyController@getAuctions');

    // Citizen
    Route::get('/citizen/{id}', 'API\CitizenController@getCitizen');
    Route::get('/citizen/name/{id}', 'API\CitizenController@getByName');

    // Political

    // Military
    Route::get('/battle/{country}', 'API\BattleController@getAll');
});
