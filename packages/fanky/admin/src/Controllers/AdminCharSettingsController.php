<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Models\Char;
use Fanky\Admin\Models\Order;
use Pagination;
use Validator;
use Request;

class AdminCharSettingsController extends AdminController {

    public function getIndex() {
        $per_page = 50;
//        $chars = Char::orderBy('name')->paginate($per_page);
        $chars = Pagination::init(new Char, 50)->orderBy('name')->get();

        return view('admin::char_settings.main', ['chars' => $chars]);
    }

    public function getView($id) {
        $char = Char::find($id);

        return view('admin::char_settings.edit', [
            'item' => $char,
        ]);
    }

    public function postSave(): array {
        $id = Request::input('id');
        $data = Request::only(['name']);

        // валидация данных
        $validator = Validator::make($data, [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->messages()];
        }

        // сохраняем страницу
        $item = Char::find($id);
        $item->update($data);

        return ['success' => true, 'msg' => 'Изменения сохранены'];
    }

    public function postDelete($id) {
        $order = Order::find($id);
        if ($order) $order->delete();

        return ['success' => true];
    }
}

