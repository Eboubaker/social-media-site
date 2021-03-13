<?php


namespace App\Casts;


use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class JsonObject implements CastsAttributes
{

    /**
     * @inheritDoc
     * @throws \JsonException
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return json_decode($value, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @inheritDoc
     * @throws \JsonException
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return json_encode($value, JSON_THROW_ON_ERROR);
    }
}
