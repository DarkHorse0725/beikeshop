<?php

namespace Beike\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'code' => 'required|max:16',
            'symbol_left' => 'max:16',
            'symbol_right' => 'max:16',
            'value' => 'required',
            'decimal_place' => 'required|max:1',
        ];
    }

    public function attributes()
    {
        return [
            'name' => trans('currency.name'),
            'code' => trans('currency.code'),
            'symbol_left' => trans('currency.symbol_left'),
            'symbol_right' => trans('currency.symbol_right'),
            'value' => trans('currency.value'),
            'decimal_place' => trans('currency.decimal_place'),
        ];
    }
}
