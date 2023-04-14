<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\DeliveryItem;
use Fanky\Admin\Models\PaymentItem;
use Request;
use Validator;
use Text;

class AdminPaymentController extends AdminController {

	public function getIndex() {
		$items = PaymentItem::orderBy('order', 'asc')->get();

		return view('admin::payment.main', ['items' => $items]);
	}

	public function getEdit($id = null) {
		$item = PaymentItem::findOrNew($id);
		return view('admin::payment.edit', ['item' => $item]);
	}

	public function postSave() {
		$id = Request::input('id');
		$data = Request::only(['name', 'description', 'order']);
//        if(!array_get($data, 'order')) $data['order'] = 0;

        // валидация данных
		$validator = Validator::make($data, [
				'name' => 'required',
			]);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

        // сохраняем страницу
		$item = PaymentItem::find($id);
		$redirect = false;
		if (!$item) {
            $data['order'] = PaymentItem::all()->max('order') + 1;
            $article = PaymentItem::create($data);
			$redirect = true;
		} else {
            $item->update($data);
		}

        return ['redirect' => route('admin.payment')];
	}

	public function postDelete($id) {
        $item = PaymentItem::find($id);
        $item->delete();

		return ['success' => true];
	}
}
