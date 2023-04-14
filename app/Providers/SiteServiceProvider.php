<?php namespace App\Providers;

use App\Classes\SiteHelper;
use Fanky\Admin\Models\Catalog;
use Fanky\Admin\Models\City;
use Request;
use Cache;
use DB;
use Fanky\Admin\Models\Complex;
use Illuminate\Support\ServiceProvider;
use View;
use Cart;
use Fanky\Admin\Models\Page;

class SiteServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		// пререндер для шаблона
		View::composer(['template'], function (\Illuminate\View\View $view) {
		    $catalogMenu = Cache::get('catalog_menu', collect());
            if(!count($catalogMenu)) {
                $catalogMenu = Catalog::getTopLevel();
                Cache::add('catalog_menu', $catalogMenu, now()->addMinutes(60));
            }

            $topMenu = Cache::get('top_menu', collect());
            if(!count($topMenu)) {
                $topMenu = Page::query()
                    ->public()
                    ->where('on_top_menu', 1)
                    ->orderBy('order')
                    ->get();
                Cache::add('top_menu', $topMenu, now()->addMinutes(60));
            }

            $cities = City::query()->orderBy('name')
                ->get(['id', 'alias', 'name', DB::raw('LEFT(name,1) as letter')]);

            if($alias = session('city_alias')) {
                $city = City::whereAlias($alias)->first();
                $current_city = $city->name;
            } else {
                $current_city = null;
            }

			$view->with(compact(
                'topMenu',
                'cities',
                'current_city',
                'catalogMenu'
            ));
		});

        View::composer(['blocks.footer'], function ($view) {
            $footerCatalog = Cache::get('footer_catalog', collect());
            if(!count($footerCatalog)) {
                $footerCatalog = Catalog::public()
                    ->where('on_footer_menu', 1)
                    ->where('parent_id', 0)
                    ->orderBy('order')
                    ->get();
                Cache::add('footer_catalog', $footerCatalog, now()->addMinutes(60));
            }

            $footerMenu = Cache::get('footer_menu', collect());
            if(!count($footerMenu)) {
                $footerMenu = Page::query()
                    ->public()
                    ->where('parent_id', 1)
                    ->where('on_footer_menu', 1)
                    ->orderBy('order')
                    ->get();
                Cache::add('footer_menu', $footerMenu, now()->addMinutes(60));
            }

            $mobileMenu = Cache::get('mobile_menu', collect());
            if(!count($mobileMenu)) {
                $mobileMenu = Page::query()
                    ->public()
                    ->where('parent_id', 1)
                    ->where('on_mobile_menu', 1)
                    ->orderBy('order')
                    ->get();
                Cache::add('mobile_menu', $mobileMenu, now()->addMinutes(60));
            }

            $catalogMenu = Cache::get('catalog_menu', collect());
            if(!count($catalogMenu)) {
                $catalogMenu = Catalog::getTopLevel();
                Cache::add('catalog_menu', $catalogMenu, now()->addMinutes(60));
            }

            $view->with(compact(
                'footerMenu',
                'footerCatalog',
                'mobileMenu',
                'catalogMenu'
            ));
        });

        View::composer(['catalog.blocks.layout_aside'], function ($view) {
            $categories = Cache::get('categories', collect());
            if(!count($categories)) {
                $categories = Catalog::public()
                    ->where('parent_id', 0)
                    ->orderBy('order')
                    ->get();
                Cache::add('catalog_index', $categories, now()->addMinutes(60));
            }

            $view->with(compact(
         'categories'
            ));
        });

        View::composer(['blocks.header_cart'], function ($view) {
            $items = Cart::all();
            $sum = 0;
            $count = count(Cart::all());
            foreach ($items as $item) {
                $sum += $item['price'];
//                $count += $item['count'];
            }
            $count .= ' ' . SiteHelper::getNumEnding($count, ['товар', 'товара', 'товаров']);

            $view->with([
                'items' => $items,
                'sum'   => $sum,
                'count' => $count
            ]);
        });
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register() {
		$this->app->singleton('settings', function () {
			return new \App\Classes\Settings();
		});
		$this->app->bind('sitehelper', function () {
			return new \App\Classes\SiteHelper();
		});
		$this->app->alias('settings', \App\Facades\Settings::class);
		$this->app->alias('sitehelper', \App\Facades\SiteHelper::class);
	}
}
