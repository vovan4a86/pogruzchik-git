<?php namespace Fanky\Admin\Models;

use App\Classes\SiteHelper;
use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Fanky\Admin\Models\Complex
 *
 * @property int                 $id
 * @property int                 $published
 * @property string|null         $date
 * @property string              $name
 * @property string|null         $announce
 * @property string|null         $text
 * @property string              $image
 * @property string              $alias
 * @property string              $title
 * @property string              $keywords
 * @property string              $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @property-read mixed          $image_src
 * @property-read mixed          $url
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\Complex onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex public ()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereAnnounce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\Complex withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Fanky\Admin\Models\Complex withoutTrashed()
 * @mixin \Eloquent
 * @property string $h1
 * @property string|null $og_title
 * @property string|null $og_description
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fanky\Admin\Models\NewsTag[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Complex whereOgTitle($value)
 */
class Complex extends Model {

	use HasImage;

	protected $table = 'complex';

	protected $guarded = ['id'];

	const UPLOAD_URL = '/uploads/complex/';
    const NO_IMAGE = '/adminlte/no_image.png';

	public static $thumbs = [
		1 => '100x50', //admin
		2 => '585x357|fit', //news_list
	];

	public function scopePublic($query) {
		return $query->where('published', 1);
	}

	public function getUrlAttribute($value) {
		return route('complex.item', ['alias' => $this->alias]);
	}

	public function dateFormat($format = 'd.m.Y') {
		if (!$this->date) return null;
		$date =  date($format, strtotime($this->date));
		$date = str_replace(array_keys(SiteHelper::$monthRu),
			SiteHelper::$monthRu, $date);

		return $date;
	}

}
