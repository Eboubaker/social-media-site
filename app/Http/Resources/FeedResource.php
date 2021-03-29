<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FeedResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        $request = [
//            "api_token" => string,
//            "parameters" => [
//                "count" => integer,
//                "viewType" => [
//                    "type" => string => "socialProfileView|businessProfileView|feedView",
//                    "profileId"? => integer // if type not feedView
//                ]
//            ]
//        ];
        return parent::toArray($request);
    }
}
