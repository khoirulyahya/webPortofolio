<?php

namespace Database\Seeders;

use App\Models\TransactionSupplier; //memanggil model
use Faker\Factory as Faker; //memanggil plugin bawaan laravel
use Illuminate\Database\Seeder;

class TransactionSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i=1; $i < 21; $i++) {
            $transactionSupplier = new TransactionSupplier; //karena memanggil nama model maka harus daftarkan diatas

            $transactionSupplier->invoice_code = $faker->ean13;
            $transactionSupplier->officer_id = $i;
            $transactionSupplier->supplier_id = $i;

            $transactionSupplier->save();
        }
        for ($e=1; $e < 21; $e++) {
            $transactionSupplier = new TransactionSupplier; //karena memanggil nama model maka harus daftarkan diatas

            $transactionSupplier->invoice_code = $faker->ean13;
            $transactionSupplier->officer_id = rand(1,20);
            $transactionSupplier->supplier_id = rand(1,20);

            $transactionSupplier->save();
        }
    }
}
