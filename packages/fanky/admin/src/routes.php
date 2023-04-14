<?php

//Route::any('admin', ['as' => 'admin', 'uses' => 'Fanky\Admin\Controllers\AdminController@main']);
use Fanky\Admin\Controllers\AdminCatalogController;
use Fanky\Admin\Controllers\AdminActionController;

Route::group(['namespace' => 'Fanky\Admin\Controllers', 'prefix' => 'admin', 'as' => 'admin'], function () {
	Route::any('/', ['uses' => 'AdminController@main']);
	Route::group(['as' => '.pages', 'prefix' => 'pages'], function () {
		$controller  = 'AdminPagesController@';
		Route::get('/', $controller . 'getIndex');
		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::post('edit/{id?}', $controller . 'postEdit')
			->name('.edit');

		Route::get('get-pages/{id?}', $controller . 'getGetPages')
			->name('.get_pages');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('reorder', $controller . 'postReorder')
			->name('.reorder');

		Route::post('delete/{id}', $controller . 'postDelete')
			->name('.del');

		Route::get('filemanager', [
			'as'   => '.filemanager',
			'uses' => $controller . 'getFileManager'
		]);

		Route::get('imagemanager', [
			'as'   => '.imagemanager',
			'uses' => $controller . 'getImageManager'
		]);

        Route::post('add-gost-file/{id}', [
            'as'   => '.addGostFile',
            'uses' => $controller . 'postAddGostFile'
        ]);

        Route::post('del-gost-file/{id}', [
            'as'   => '.delGostFile',
            'uses' => $controller . 'postDelGostFile'
        ]);

        Route::post('update-gost-file-order/{id}', [
            'as'   => '.updateGostFileOrder',
            'uses' => $controller . 'postUpdateGostFileOrder'
        ]);
	});

	Route::group(['as' => '.catalog', 'prefix' => 'catalog'], function () {
		$controller  = 'AdminCatalogController@';
		Route::get('/', [AdminCatalogController::class, 'getIndex']);

		Route::get('products/{id?}', $controller . 'getProducts')
			->name('.products');

		Route::post('catalog-edit/{id?}', $controller . 'postCatalogEdit')
			->name('.catalogEdit');

		Route::get('catalog-edit/{id?}', $controller . 'getCatalogEdit')
			->name('.catalogEdit');

		Route::post('catalog-save', $controller . 'postCatalogSave')
			->name('.catalogSave');

		Route::post('catalog-reorder', $controller . 'postCatalogReorder')
			->name('.catalogReorder');

		Route::post('catalog-delete/{id}', $controller . 'postCatalogDelete')
			->name('.catalogDel');

		Route::get('product-edit/{id?}', $controller . 'getProductEdit')
			->name('.productEdit');

		Route::post('product-save', $controller . 'postProductSave')
			->name('.productSave');

		Route::post('product-reorder', $controller . 'postProductReorder')
			->name('.productReorder');

		Route::post('update-order/{id}', $controller . 'postUpdateOrder')
			->name('.update-order');

		Route::post('product-delete/{id}', $controller . 'postProductDelete')
			->name('.productDel');

		Route::post('product-image-upload/{id}', $controller . 'postProductImageUpload')
			->name('.productImageUpload');

		Route::post('product-image-delete/{id}', $controller . 'postProductImageDelete')
			->name('.productImageDel');

		Route::post('product-image-order', $controller . 'postProductImageOrder')
			->name('.productImageOrder');

		Route::get('get-catalogs/{id?}', $controller . 'getGetCatalogs')
			->name('.get_catalogs');

        Route::post('add-doc/{id}', [
            'as'   => '.add_doc',
            'uses' => $controller . 'postAddDoc'
        ]);

        Route::post('del-doc/{id}', [
            'as'   => '.del_doc',
            'uses' => $controller . 'postDelDoc'
        ]);

        Route::post('save-related/{id}', [
            'as'   => '.save_related',
            'uses' => $controller . 'postSaveRelated'
        ]);

        Route::post('update-filter-title/{id}', [
            'as'   => '.update-filter-title',
            'uses' => $controller . 'postUpdateFilterTitle'
        ]);

        Route::post('add-menu-action/{id}', [
            'as'   => '.addMenuAction',
            'uses' => $controller . 'postAddMenuAction'
        ]);

        Route::post('delete-menu-action/{id}', [
            'as'   => '.deleteMenuAction',
            'uses' => $controller . 'postDeleteMenuAction'
        ]);
        Route::post('update-menu-action/{id}', [
            'as'   => '.updateMenuAction',
            'uses' => $controller . 'postUpdateMenuAction'
        ]);
	});

	Route::group(['as' => '.complex', 'prefix' => 'complex'], function () {
		$controller = 'AdminComplexController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('delete/{id}', $controller . 'postDelete')
			->name('.delete');

		Route::post('delete-image/{id}', $controller . 'postDeleteImage')
			->name('.delete-image');
	});

    Route::group(['as' => '.contacts', 'prefix' => 'contacts'], function () {
        $controller = 'AdminContactsController@';
        Route::get('/', $controller . 'getIndex');

        Route::get('edit/{id?}', $controller . 'getEdit')
            ->name('.edit');

        Route::post('save', $controller . 'postSave')
            ->name('.save');

        Route::post('delete/{id}', $controller . 'postDelete')
            ->name('.delete');

        Route::post('update-order/{id}', $controller . 'postUpdateOrder')
            ->name('.update-order');
    });

    Route::group(['as' => '.delivery', 'prefix' => 'delivery'], function () {
        $controller = 'AdminDeliveryController@';
        Route::get('/', $controller . 'getIndex');

        Route::get('edit/{id?}', $controller . 'getEdit')
            ->name('.edit');

        Route::post('save', $controller . 'postSave')
            ->name('.save');

        Route::post('delete/{id}', $controller . 'postDelete')
            ->name('.delete');

        Route::post('update-order/{id}', $controller . 'postUpdateOrder')
            ->name('.update-order');
    });

    Route::group(['as' => '.payment', 'prefix' => 'payment'], function () {
        $controller = 'AdminPaymentController@';
        Route::get('/', $controller . 'getIndex');

        Route::get('edit/{id?}', $controller . 'getEdit')
            ->name('.edit');

        Route::post('save', $controller . 'postSave')
            ->name('.save');

        Route::post('delete/{id}', $controller . 'postDelete')
            ->name('.delete');

        Route::post('update-order/{id}', $controller . 'postUpdateOrder')
            ->name('.update-order');
    });

    Route::group(['as' => '.offers', 'prefix' => 'offers'], function () {
		$controller = 'AdminOffersController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('delete/{id}', $controller . 'postDelete')
			->name('.delete');

		Route::post('delete-image/{id}', $controller . 'postDeleteImage')
			->name('.delete-image');
	});

    Route::group(['as' => '.orders', 'prefix' => 'orders'], function () {
		$controller = 'AdminOrdersController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('view/{id?}', $controller . 'getView')
			->name('.view');

		Route::post('del/{id}', $controller . 'postDelete')
			->name('.del');
	});

	Route::group(['as' => '.publications', 'prefix' => 'publications'], function () {
		$controller = 'AdminPublicationsController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('delete/{id}', $controller . 'postDelete')
			->name('.delete');

	});

	Route::group(['as' => '.gallery', 'prefix' => 'gallery'], function () {
		$controller = 'AdminGalleryController@';
		Route::get('/', $controller . 'anyIndex');
		Route::post('gallery-save', $controller . 'postGallerySave')
			->name('.gallerySave');
		Route::post('gallery-edit/{id?}', $controller . 'postGalleryEdit')
			->name('.gallery_edit');
		Route::post('gallery-delete/{id}', $controller . 'postGalleryDelete')
			->name('.galleryDel');
		Route::any('items/{id}', $controller . 'anyItems')
			->name('.items');
		Route::post('image-upload/{id}', $controller . 'postImageUpload')
			->name('.imageUpload');
		Route::post('image-edit/{id}', $controller . 'postImageEdit')
			->name('.imageEdit');
		Route::post('image-data-save/{id}', $controller . 'postImageDataSave')
			->name('.imageDataSave');
		Route::post('image-del/{id}', $controller . 'postImageDelete')
			->name('.imageDel');
		Route::post('image-order', $controller . 'postImageOrder')
			->name('.order');
	});

	Route::group(['as' => '.reviews', 'prefix' => 'reviews'], function () {
		$controller = 'AdminReviewsController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('reorder', $controller . 'postReorder')
			->name('.reorder');

		Route::post('delete/{id}', $controller . 'postDelete')
			->name('.del');
	});

	Route::group(['as' => '.settings', 'prefix' => 'settings'], function () {
		$controller = 'AdminSettingsController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('group-items/{id?}', $controller . 'getGroupItems')
			->name('.groupItems');

		Route::post('group-save', $controller . 'postGroupSave')
			->name('.groupSave');

		Route::post('group-delete/{id}', $controller . 'postGroupDelete')
			->name('.groupDel');

		Route::post('clear-value/{id}', $controller . 'postClearValue')
			->name('.clearValue');

		Route::any('edit/{id?}', $controller . 'anyEditSetting')
			->name('.edit');

		Route::any('block-params', $controller . 'anyBlockParams')
			->name('.blockParams');

		Route::post('edit-setting-save', $controller . 'postEditSettingSave')
			->name('.editSave');

		Route::post('save', $controller . 'postSave')
			->name('.save');
	});

	Route::group(['as' => '.char_settings', 'prefix' => 'char_settings'], function () {
		$controller = 'AdminCharSettingsController@';
		Route::get('/', $controller . 'getIndex');

		Route::any('edit/{id?}', $controller . 'getView')
			->name('.edit');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('del', $controller . 'postDelete')
			->name('.del');
	});

	Route::group(['as' => '.redirects', 'prefix' => 'redirects'], function () {
		$controller = 'AdminRedirectsController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::get('delete/{id}', $controller . 'getDelete')
			->name('.delete');

		Route::post('save', $controller . 'postSave')
			->name('.save');
	});

	Route::group(['as' => '.feedbacks', 'prefix' => 'feedbacks'], function () {
		$controller = 'AdminFeedbacksController@';
		Route::get('/', $controller . 'getIndex');

		Route::post('read/{id?}',$controller . 'postRead')
			->name('.read');
		Route::post('delete/{id?}', $controller . 'postDelete')
			->name('.del');
	});

	Route::group(['as' => '.users', 'prefix' => 'users'], function () {
		$controller = 'AdminUsersController@';
		Route::get('/', $controller . 'getIndex');

		Route::post('edit/{id?}', $controller . 'postEdit')
			->name('.edit');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('del/{id}', $controller . 'postDelete')
			->name('.del');
	});

	Route::group(['as' => '.cities', 'prefix' => 'cities'], function () {
		$controller = 'AdminCitiesController@';
		Route::get('/', $controller . 'getIndex');

		Route::get('edit/{id?}', $controller . 'getEdit')
			->name('.edit');

		Route::post('delete/{id}', $controller . 'postDelete')
			->name('.del');

		Route::post('save', $controller . 'postSave')
			->name('.save');

		Route::post('tree/{id?}', $controller . 'postTree')
			->name('.tree');
	});
});
