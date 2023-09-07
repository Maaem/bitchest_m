<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperWallet
 */
class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ["quantity"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
