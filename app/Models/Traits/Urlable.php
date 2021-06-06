<?php


namespace App\Models\Traits;

/**
 * @property string $url
 */
trait Urlable
{
    public abstract function getUrlAttribute(): string;
}
