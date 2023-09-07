<?php

namespace App\Http\Requests;

use App\Rules\EnoughMoney;
use Illuminate\Foundation\Http\FormRequest;

class StoreCryptoWalletRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "quantity" => ["numeric", new EnoughMoney()],
            "currency_id" => "exists:currencies,id",
        ];
    }

    public function validated($key = null, $default = null)
    {
        return array_merge(
            [
                "user_id" => \Auth::user()->id,
            ],
            parent::validated(),
        );
    }
}
