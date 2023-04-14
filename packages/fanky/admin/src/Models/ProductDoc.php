<?php namespace Fanky\Admin\Models;

use App\Traits\HasFile;
use Illuminate\Database\Eloquent\Model;

/**
 * Fanky\Admin\Models\ProductParam
 *
 * @property-read \Fanky\Admin\Models\Catalog $catalog
 * @property-read \Fanky\Admin\Models\Product $product
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_id
 * @property int $catalog_id
 * @property string $name
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\ProductChar whereCatalogId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\ProductChar whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\ProductChar whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\ProductChar whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\ProductChar whereValue($value)
 */
class ProductDoc extends Model {
    use HasFile;

	protected $guarded = ['id'];
	protected $table = 'product_docs';
	public $timestamps = false;

	const UPLOAD_URL = '/uploads/docs/';

	public function product(){
		return $this->belongsTo(Product::class);
	}

	public function getExtension() {
        return strtoupper(explode('.', $this->file)[1]);
    }
}
