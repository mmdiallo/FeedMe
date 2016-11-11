<?php

use Illuminate\Database\Seeder;
use App\AccountType;

class AccountTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_type = new AccountType;
        $user_type->account_type = 'user';
        $user_type->save();
        $restaurant_type = new AccountType;
        $restaurant_type->account_type = 'restaurant';
        $restaurant_type->save();
    }
}
