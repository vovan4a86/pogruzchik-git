<?php namespace Fanky\Admin\Controllers;

use App\Exports\CraneSpareExport;
use App\Http\Controllers\Controller;
use Fanky\Admin\Models\AdminLog;
use Maatwebsite\Excel\Facades\Excel;
use Request;
use Validator;
use App\User;
use Auth;

use Fanky\Admin\Models\GalleryItem;
use Fanky\Admin\Models\Complex;
use Image;
use Thumb;

class AdminController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth.fanky');
		$this->middleware('menu.admin');
	}

	public function main() {
		$logs = AdminLog::orderBy('created_at', 'desc')->paginate(30);
		return view('admin::main', [
			'logs'	=> $logs
		]);
	}

	public function exportCrane()
    {
        return Excel::download(new CraneSpareExport, 'crane-spare-list.xlsx');
    }

}
