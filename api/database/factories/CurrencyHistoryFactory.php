<?php

namespace Database\Factories;

use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Utils\Quoting;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CurrencyHistory>
 */
class CurrencyHistoryFactory extends Factory
{
    protected static int $index = 0;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = Carbon::now()->subDays($this::$index);
        $this::$index += 1;
        if ($this::$index === 30) {
            $this::$index = 0;
        }
        return [
            "currency_id" => Currency::factory(),
            "date" => $date,
        ];
    }

    /**
     * Define the quotation for day one or other days.
     * @return Factory
     */
    public function generateQuoting(): Factory
    {
        if ($this::$index === 0) {
            $this->state(function (array $att, Currency $currency) {
                return ["quoting" => Quoting::getFirstCotation($currency->crypto_name)];
            });
        }
        return $this->state(function (array $att, Currency $currency) {
            return ["quoting" => Quoting::getCotationFor($currency->crypto_name)];
        });
    }
}
