<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['auth', 'visitor'], 'namespace' => 'Visitor'], function($router) {
    $router->get('/', ['uses' => 'IndexController@index', 'as' => 'visitor.home']);

});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function($router) {

    $router->get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    $router->post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

    $router->group(['middleware' => ['admin']], function($router) {

        $router->get('/', ['uses' => 'IndexController@index', 'as' => 'admin.panel']);
        $router->resources([
            'users' => 'UserController',
            'images' => 'ImageController',
        ]);
    });
});