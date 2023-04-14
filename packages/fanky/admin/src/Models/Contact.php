<?php namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Fanky\Admin\Models\Contact
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $city_id
 * @property string $title
 * @property string $address
 * @property string $phone1
 * @property string $phone1_comment
 * @property string $phone2
 * @property string $phone2_comment
 * @property string $email
 * @property string $work_days
 * @property float  $lat
 * @property float  $long
 * @property string  $whatsapp
 * @property string  $skype
 * @property string  $telegram
 * @property int    $order
 */
class Contact extends Model {

	protected $guarded = ['id'];

	public $timestamps = false;

	public function city(): BelongsTo{
		return $this->belongsTo(City::class);
	}
}
