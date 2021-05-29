<?php


namespace App\Models\Traits;

trait Sluggable
{
    public abstract function getSlugAttribute():string;
}
