<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ProfileData
 *
 * @property int $id
 * @property int $profile_id
 * @property string|null $website_url
 * @property string|null $country
 * @property string|null $city
 * @property string|null $address
 * @property-read \App\Models\Profile $profile
 * @method static \Database\Factories\ProfileDataFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileData query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileData whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileData whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileData whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileData whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileData whereWebsiteUrl($value)
 * @mixin \Eloquent
 */
class ProfileData extends Model
{
    use HasFactory;
    
    public const CREATED_AT = null;
    public const UPDATED_AT = null;
    public const DELETED_AT = null;

    public static function boot()
    {
        parent::boot();
        static::saving(function (ProfileData $data) {
            if (empty($data->website_url)) {
                $data->website_url = $data->profile->name;
            }
        });
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
