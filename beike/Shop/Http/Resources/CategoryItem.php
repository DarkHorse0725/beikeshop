<?php

namespace Beike\Shop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $item = [
            'id' => $this->id,
            'name' => $this->description->name ?? '',

        ];
        if ($this->children) {
            $item['children'] = self::collection($this->children);
        }
        return $item;
    }
}
