<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required',
            'address' => 'required|string',
            'email' => 'email',
            'shipping_service' => 'required|string',
        ];

        $shipTo = $this->get('ship_to');

        if ($shipTo) {
            $rules = array_merge(
                $rules,
                [
                    'shipping_first_name' => 'required|string',
                    'shipping_last_name' => 'required|string',
                    'shipping_address' => 'required|string',
                    'shipping_phone' => 'required',
                ]
            );
        }

        return $rules;
    }
}
