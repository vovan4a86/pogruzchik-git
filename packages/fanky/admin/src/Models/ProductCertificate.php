<?php namespace Fanky\Admin\Models;

use App\Traits\HasImage;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Thumb;

/**
 * Fanky\Admin\Models\ProductImage
 *
 * @property int        $id
 * @property int        $product_id
 * @property string     $image
 * @property int        $order
 * @property-read mixed $src
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage whereProductId($value)
 * @mixin Eloquent
 * @property-read mixed $image_src
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\ProductImage query()
 */
class ProductCertificate extends Model {

	use HasImage;
	protected $table = 'product_certificates';

	protected $fillable = ['product_id', 'image', 'order'];

	public $timestamps = false;

	const UPLOAD_URL = '/uploads/certificates/';

	public static $thumbs = [
		1 => '376x295', //admin product_list
		2 => '112x61', //list_row
		3 => '586x386', //product_page
	];


}
