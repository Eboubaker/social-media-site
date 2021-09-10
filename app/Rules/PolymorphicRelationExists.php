<?php

namespace App\Rules;

use Exception;
use Illuminate\Contracts\Validation\Rule;

class PolymorphicRelationExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($model, $relation)
    {
        $this->model = $model;
        $this->relation = $relation;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // dd($this->model);
        try{
            $id = $this->relation."_id";
            $type = $this->relation."_type";
            return $this->model->{$type}::where('id', $this->model->{$id})->exists();
        }catch(Exception $e)
        {
            report($e);
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'this item does not exist.';
    }
}
