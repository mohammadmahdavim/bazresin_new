<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'fname' => $this->resource->fname,
            'lname' => $this->resource->lname,
            'username' => $this->resource->username,
            'mobile' => $this->resource->mobile,
            'avatar' => $this->resource->avatar,
            'api_token' => $this->resource->api_token,
        ];
    }
}
