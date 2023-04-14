<?php namespace Fanky\Admin\Controllers;

use Fanky\Admin\Settings;
use Illuminate\Support\Str;
use Request;
use Validator;
use Text;
use Thumb;
use Image;
use Fanky\Admin\Models\Complex;

class AdminComplexController extends AdminController {

	public function getIndex() {
		$complex = Complex::orderBy('date', 'desc')->paginate(100);

		return view('admin::complex.main', ['complex' => $complex]);
	}

	public function getEdit($id = null) {
		if (!$id || !($article = Complex::find($id))) {
			$article = new Complex;
			$article->date = date('Y-m-d');
			$article->published = 1;
		}

		return view('admin::complex.edit', ['article' => $article]);
	}

	public function postSave() {
		$id = Request::input('id');
		$data = Request::only(['date', 'name', 'announce', 'text', 'published',
                                'alias', 'title', 'keywords', 'description', 'city', 'square']);
		$image = Request::file('image');

		if (!array_get($data, 'alias')) $data['alias'] = Text::translit($data['name']);
		if (!array_get($data, 'title')) $data['title'] = $data['name'];
		if (!array_get($data, 'published')) $data['published'] = 0;

		// валидация данных
		$validator = Validator::make(
			$data,[
				'name' => 'required',
				'date' => 'required',
			]);
		if ($validator->fails()) {
			return ['errors' => $validator->messages()];
		}

		// Загружаем изображение
		if ($image) {
			$file_name = Complex::uploadImage($image);
			$data['image'] = $file_name;
		}

		// сохраняем страницу
		$article = Complex::find($id);
		$redirect = false;
		if (!$article) {
			$article = Complex::create($data);
			$redirect = true;
		} else {
			if ($article->image && isset($data['image'])) {
				$article->deleteImage();
			}
			$article->update($data);
		}
//		$article->tags()->sync($tags);

		if($redirect){
			return ['redirect' => route('admin.complex.edit', [$article->id])];
		} else {
			return ['msg' => 'Изменения сохранены.'];
		}

	}

	public function postDelete($id) {
		$article = Complex::find($id);
		$article->delete();

		return ['success' => true];
	}

	public function postDeleteImage($id) {
		$news = Complex::find($id);
		if(!$news) return ['error' => 'news_not_found'];

		$news->deleteImage();
		$news->update(['image' => null]);

		return ['success' => true];
	}
}
