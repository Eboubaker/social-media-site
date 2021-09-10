<?php


namespace App\Models\Traits;


interface Attachement
{
    public function attacheable();
    public static function extractAttributesFromFile($path);
}
