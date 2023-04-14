<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Http\Controllers\AjaxController;

Route::get('robots.txt', 'PageController@robots')->name('robots');

Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
    Route::post('add-to-cart', [AjaxController::class, 'postAddToCart'])->name('add-to-cart');
    Route::post('update-to-cart', [AjaxController::class, 'postUpdateToCart'])->name('update-to-cart');
    Route::post('remove-from-cart', [AjaxController::class, 'postRemoveFromCart'])->name('remove-from-cart');
    Route::post('purge-cart', [AjaxController::class, 'postPurgeCart'])->name('purge-cart');
    Route::post('edit-cart-product', [AjaxController::class, 'postEditCartProduct'])->name('edit-cart-product');
    Route::post('order', [AjaxController::class, 'postOrder'])->name('order');
	Route::post('request', 'AjaxController@postRequest')->name('request');
    Route::post('consultation', 'AjaxController@postConsultation')->name('consultation');
    Route::post('product-consult', 'AjaxController@postProductConsult')->name('product-consult');
    Route::post('optimal-decision', 'AjaxController@postOptimalDecision')->name('optimal-decision');
    Route::post('complex-decision', 'AjaxController@postComplexDecision')->name('complex-decision');
	Route::post('writeback', 'AjaxController@postWriteback')->name('writeback');
	Route::post('manager-request', 'AjaxController@postManagerRequest')->name('manager-request');
	Route::post('callback', 'AjaxController@postCallback')->name('callback');
    Route::post('set-city', 'AjaxController@setCity')->name('set-city');
    Route::post('confirm-city', 'AjaxController@confirmCity')->name('confirm-city');
    Route::post('unconfirm-city', 'AjaxController@unConfirmCity')->name('unconfirm-city');
    Route::post('get-correct-region-link', 'AjaxController@postGetCorrectRegionLink')->name('get-correct-region-link');
    Route::get('show-popup-cities', [AjaxController::class, 'showCitiesPopup'])->name('show-popup-cities');
    Route::post('update-char-value', [AjaxController::class, 'postUpdateProductCharValue'])->name('update-char-value');
});

Route::group(['middleware' => ['redirects', 'regions']], function() {
    $cities = getCityAliases();
    $cities = implode('|', $cities);
    Route::group([
        'prefix' => '{city}',
        'as'     => 'region.',
        'where'  => ['city' => $cities]
    ], function () use ($cities) {
        Route::get('/', ['as' => 'index', 'uses' => 'PageController@page']);

        Route::group(['prefix' => 'catalog', 'as' => 'catalog.'], function () {
            Route::any('/', ['as' => 'index', 'uses' => 'CatalogController@index']);
            Route::any('{alias}', ['as' => 'view', 'uses' => 'CatalogController@view'])
                ->where('alias', '([A-Za-z0-9\-\/_]+)');
        });

        Route::any('{alias}', ['as' => 'pages', 'uses' => 'PageController@region_page'])
            ->where('alias', '([A-Za-z0-9\-\/_]+)');
    });

    Route::get('/', ['as' => 'main', 'uses' => 'WelcomeController@index']);

    Route::get('/about', ['as' => 'about', 'uses' => 'AboutController@index']);

    Route::any('/kompleksnie-resheniya', ['as' => 'kompleksnie-resheniya', 'uses' => 'ComplexController@index']);
    Route::get('/kompleksnie-resheniya/{alias}', ['as' => 'complex.item', 'uses' => 'ComplexController@item']);

    Route::any('/delivery-pay', ['as' => 'delivery-pay', 'uses' => 'DeliveryController@index']);

    Route::any('services', ['as' => 'services', 'uses' => 'ServiceController@index']);
    Route::get('services/{alias}', ['as' => 'services.item', 'uses' => 'ServiceController@view'])
        ->where('alias', '([A-Za-z0-9\-\/_]+)');

    Route::any('publications', ['as' => 'publications', 'uses' => 'PublicationController@index']);
    Route::get('publications/{alias}', ['as' => 'publications.item', 'uses' => 'PublicationController@item']);

    Route::any('offers', ['as' => 'offers', 'uses' => 'OfferController@index']);
    Route::get('offers/{alias}', ['as' => 'offers.item', 'uses' => 'OfferController@item']);

    Route::any('vacancy', ['as' => 'vacancy', 'uses' => 'VacancyController@index']);

    Route::any('reviews', ['as' => 'reviews', 'uses' => 'ReviewsController@index']);

    Route::any('partners', ['as' => 'partners', 'uses' => 'PartnersController@index']);

    Route::any('contacts', ['as' => 'contacts', 'uses' => 'ContactsController@index']);

    Route::any('suppliers', ['as' => 'suppliers', 'uses' => 'SuppliersController@index']);

    Route::any('gosts', ['as' => 'gosts', 'uses' => 'GostsController@index']);

    Route::any('faq', ['as' => 'faq', 'uses' => 'FaqController@index']);

    Route::any('search', ['as' => 'search', 'uses' => 'SearchController@getIndex']);

    Route::get('cart', ['as' => 'cart', 'uses' => 'CartController@getIndex']);

    Route::get('create-order', ['as' => 'create-order', 'uses' => 'CartController@getCreateOrder']);

    Route::get('order-success/{id?}', ['as' => 'order-success', 'uses' => 'CartController@showSuccess']);

    Route::get('ajax-cities', ['as' => 'ajax-cities', 'uses' => 'PageController@ajaxCities']);

    Route::get('policy', ['as' => 'policy', 'uses' => function() {
        return view('pages.policy');
    }]);

    Route::any('catalog', ['as' => 'catalog.index', 'uses' => 'CatalogController@index']);

    Route::any('catalog/{alias}', ['as' => 'catalog.view', 'uses' => 'CatalogController@view'])
        ->where('alias', '([A-Za-z0-9\-\/_]+)');

    Route::any('{alias}', ['as' => 'default', 'uses' => 'PageController@page'])
        ->where('alias', '([A-Za-z0-9\-\/_]+)');
});
