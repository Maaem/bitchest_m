<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CryptoWalletRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "quantity" => $this->quantity,
            "created_at" => $this->when(
                $this->created_at?->format("d-m-Y"),
                $this->created_at?->format("d-m-Y"),
            ),
            "capital_gain" => $this->capital_gain,
            "currency" => CurrencyResource::make($this->whenLoaded("currency")),
        ];
    }
}
