<?php

namespace Database\Seeders;

use App\Models\TransactionSupplier;
use App\Models\TransactionSupplierDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            CategorySeeder::class,
            MemberSeeder::class,
            OfficerSeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
            TransactionSupplierSeeder::class,
            TransactionSupplierDetailSeeder::class,
            TransactionSaleSeeder::class,
            TransactionSaleDetailSeeder::class
        ]);
    }
}
