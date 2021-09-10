<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * App\Models\Category
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Community[] $communities
 * @property-read int|null $communities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;


    public function communities()
    {
        return $this->belongsToMany(Community::class, 'communities_categories');
    }

    public function getPublicNameAttribute()
    {
        return empty($this->visible_name) ? Str::camel($this->name) : $this->visible_name;
    }
}
