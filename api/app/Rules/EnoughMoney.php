<?php

namespace App\Rules;

use App\Models\CurrencyHistory;
use App\Models\Wallet;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class EnoughMoney implements DataAwareRule, ValidationRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    // ...

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     * @return $this
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $walletQuantity = Wallet::where("user_id", "=", \Auth::user()->id)->first(["quantity"]);
        $quoting = CurrencyHistory::whereDate("date", now())
            ->where("currency_id", "=", $this->data["currency_id"])
            ->first(["quoting"]);

        $max = $walletQuantity->quantity / $quoting->quoting;
        if ($value > $max) {
            $fail("Vous n'avez pas assez de fonds !");
        }
    }
}
