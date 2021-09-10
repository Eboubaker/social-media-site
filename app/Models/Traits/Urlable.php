<?php


namespace App\Models\Traits;

/**
 * @property string $url the client browser url to this item
 */
trait Urlable
{
    public abstract function getUrlAttribute(): string;
}
