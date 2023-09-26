<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
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
    public function getUserWallet(): Wallet|Model
    {
        return $this::where("user_id", \Auth::user()->id)->first();
    }
}
