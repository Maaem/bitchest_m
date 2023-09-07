<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Currency;
use App\Models\CurrencyHistory;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        User::factory(2)
             ->state(new Sequence(["role" => "client"], ["role" => "admin"]))
             ->has(Wallet::factory()->count(1))
             ->create();
        //            ->each(function ($user) {
        //                $wallet = Wallet::factory()->make();
        //                $user->wallet()->save($wallet);
        //            });
        Currency::factory(10)
            ->has(
                CurrencyHistory::factory()
                    ->count(30)
                    ->generateQuoting(),
            )
            ->create();
    }
}
