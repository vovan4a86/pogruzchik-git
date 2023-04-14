<?php namespace App\Http\Controllers;

use App;
use Fanky\Admin\Models\Complex;
use Fanky\Admin\Models\DeliveryItem;
use Fanky\Admin\Models\NewsTag;
use Fanky\Admin\Models\Page;
//use Request;
use Fanky\Admin\Models\Partner;
use Fanky\Admin\Models\PaymentItem;
use Illuminate\Http\Request;
use Settings;
use View;

class DeliveryController extends Controller {
	public $bread = [];
	protected $delivery_page;

	public function __construct() {
		$this->delivery_page = Page::whereAlias('delivery-pay')
			->get()
			->first();
		$this->bread[] = [
			'url'  => $this->delivery_page['url'],
			'name' => $this->delivery_page['name']
		];
	}

	public function index(Request $request) {
		$page = $this->delivery_page;
        $page->setSeo();

        $bread = $this->bread;

        if (count($request->query())) {
            View::share('canonical', $this->delivery_page->alias);
        }

        $deliveries = DeliveryItem::all()->sortBy('order');

        $payments = PaymentItem::all()->sortBy('order');
        if(count($payments) > 2) $payments = $payments->chunk(2);

        return view('delivery.index', [
            'bread' => $bread,
            'h1' => $page->h1,
            'title' => $page->title,
            'text' => $page->text,
            'deliveries' => $deliveries,
            'payments' => $payments,
        ]);
	}

}
