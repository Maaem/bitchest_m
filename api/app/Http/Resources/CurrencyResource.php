<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "crypto_name" => $this->crypto_name,
            "currency_histories" => CurrencyHistoryResource::collection(
                $this->whenLoaded("currencyHistories"),
            ),
        ];
    }
}
