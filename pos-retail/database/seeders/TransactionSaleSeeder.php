<?php

namespace Database\Seeders;

use App\Models\TransactionSale; //memanggil model
use Faker\Factory as Faker; //memanggil plugin bawaan laravel
use Illuminate\Database\Seeder;

class TransactionSaleSeeder extends Seeder
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
            $transactionSale = new TransactionSale; //karena memanggil nama model maka harus daftarkan diatas

            $transactionSale->invoice_code = $faker->ean13;
            $transactionSale->officer_id = $i;
            if ($i%2 == 0) {
                # code...
                $transactionSale->member_id = $i;
            }

            $transactionSale->save();
        }
        for ($e=1; $e < 21; $e++) {
            $transactionSale = new TransactionSale; //karena memanggil nama model maka harus daftarkan diatas

            $transactionSale->invoice_code = $faker->ean13;
            $transactionSale->officer_id = rand(1,20);
            if ($e%2 == 0) {
                # code...
                $transactionSale->member_id = rand(1,20);
            }

            $transactionSale->save();
        }
    }
}
