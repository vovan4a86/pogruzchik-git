<?php namespace Fanky\Admin\Models;

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
class ProductChar extends Model {
	protected $guarded = ['id'];
	protected $table = 'product_chars';
	public $timestamps = false;

	public function product(){
		return $this->belongsTo(Product::class);
	}
}
