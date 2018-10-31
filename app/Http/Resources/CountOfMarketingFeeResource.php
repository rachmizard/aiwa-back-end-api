<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CountOfMarketingFeeResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $sum;

    public function toArray($request, $sum)
    {
        // return parent::toArray($request);
        return [
            'total' => $this->marketing_fee
        ];
    }
}
