<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->public_id,
            'avatarImage' => $this->avatarImage->url,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
        ];
    }
}
