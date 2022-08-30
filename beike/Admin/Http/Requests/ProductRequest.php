<?php
/**
 * PageRequest.php
 *
 * @copyright  2022 opencart.cn - All Rights Reserved
 * @link       http://www.guangdawangluo.com
 * @author     Edward Yang <yangjin@opencart.cn>
 * @created    2022-08-19 21:58:20
 * @modified   2022-08-19 21:58:20
 */

namespace Beike\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'descriptions.*.name' => 'required|string|min:3|max:128',
            'brand_id' => 'int',
            'skus.*.sku' => 'required|string',
            'skus.*.price' => 'required|numeric',
            'skus.*.origin_price' => 'required|numeric',
            'skus.*.cost_price' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'descriptions.*.name' => trans('product.name'),
            'brand_id' => trans('product.brand'),
            'skus.*.sku' => trans('product.sku'),
            'skus.*.price' => trans('product.price'),
            'skus.*.origin_price' => trans('product.origin_price'),
            'skus.*.cost_price' => trans('product.cost_price'),
        ];
    }
}
