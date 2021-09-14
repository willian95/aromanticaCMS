<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            "couponCode" => "required|unique:coupons,coupon_code",
            "endDate" => "required|date|after_or_equal:".date('Y-m-d'),
            "discountAmount" => "required"
        ];
    }

    public function messages()
    {
        return [
            "couponCode.required" => "Código del cupón es requerido",
            "couponCode.unique" => "Éste código ya existe",
            "endDate.required" => "Fecha limite es requerida",
            "endDate.date" => "Fecha limite no tiene un formato correcto",
            "endDate.after_or_equal" => "Fecha limite está en el pasado",
            "discountAmount.required" => "Monto a descontar es requerido"
        ];
    }
}
