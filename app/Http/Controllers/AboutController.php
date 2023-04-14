<?php

namespace App\Http\Controllers;

use Fanky\Admin\Models\Page;
use Illuminate\Http\Request;

class AboutController extends Controller {

  public function __construct() {
    $this->contacts_page = Page::whereAlias('about')
      ->get()
      ->first();
    $this->bread[] = [
      'url' => $this->contacts_page['url'],
      'name' => $this->contacts_page['name']
    ];
  }

  public function index(Request $request) {
    $page = $this->contacts_page;
    $page->setSeo();

    if (!$page)
      abort(404, 'Страница не найдена');
    $bread = $this->bread;

    if (count($request->query())) {
      View::share('canonical', $this->contacts_page->alias);
    }

    return view('about.index', [
      'bread' => $bread,
      'h1' => $page->h1,
      'title' => $page->title,
      'text' => $page->text,
    ]);
  }

}
