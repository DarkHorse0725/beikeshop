<?php
/**
 * BrandDetail.php
 *
 * @copyright  2022 opencart.cn - All Rights Reserved
 * @link       http://www.guangdawangluo.com
 * @author     TL <mengwb@opencart.cn>
 * @created    2022-08-03 10:33:06
 * @modified   2022-08-03 10:33:06
 */

namespace Beike\Shop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RmaDetail extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'order_product_id' => $this->order_product_id,
            'quantity' => $this->quantity,
            'opened' => $this->opened,
            'type' => $this->type,
            'comment' => $this->comment,
            'status' => $this->status,
            'created_at' => time_format($this->created_at),
            'email' => $this->email,
            'telephone' => $this->telephone,
            'product_name' => $this->product_name,
            'name' => $this->name,
            'sku' => $this->sku,
            'reason' => $this->reason->name,
            'type_text' => $this->type_text,
        ];
    }
}
