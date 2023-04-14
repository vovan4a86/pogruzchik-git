<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\DeliveryItem;
use Request;
use Validator;
use Text;

class AdminDeliveryController extends AdminController {

	public function getIndex() {
		$items = DeliveryItem::orderBy('order', 'asc')->get();

		return view('admin::delivery.main', ['items' => $items]);
	}

	public function getEdit($id = null) {
		$item = DeliveryItem::findOrNew($id);
		return view('admin::delivery.edit', ['item' => $item]);
	}

	public function postSave() {
		$id = Request::input('id');
		$data = Request::only(['name', 'description', 'address', 'header_text', 'text', 'order']);
//        if(!array_get($data, 'order')) $data['order'] = 0;
        $icon = Request::file('icon');
        \Debugbar::log($icon);

        // валидация данных
		$validator = Validator::make($data, [
				'name' => 'required',
			]);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		if($icon) {
            $file_name = DeliveryItem::uploadIcon($icon);
            $data['icon'] = $file_name;
        }

        // сохраняем страницу
		$item = DeliveryItem::find($id);
		$redirect = false;
		if (!$item) {
            $data['order'] = DeliveryItem::all()->max('order') + 1;
            DeliveryItem::create($data);
			$redirect = true;
		} else {
            $item->update($data);
		}

        return ['redirect' => route('admin.delivery')];
	}

	public function postDelete($id) {
        $item = DeliveryItem::find($id);
        $item->delete();

		return ['success' => true];
	}
}
