<?php


namespace App\Models\Traits;

trait Urlable
{
    public abstract function getUrlAttribute(): string;
}
