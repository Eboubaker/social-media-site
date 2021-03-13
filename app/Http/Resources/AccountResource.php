<?php

namespace App\Http\Resources;

use App\Models\Account;
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
            'id' => $this->{Account::PKEY},
            'profileImage' => $this->profileImage->url,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
        ];
    }
}
