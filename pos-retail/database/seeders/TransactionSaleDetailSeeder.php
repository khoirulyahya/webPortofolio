<?php

namespace Database\Seeders;

use App\Models\TransactionSaleDetail; //memanggil model
use Faker\Factory as Faker; //memanggil plugin bawaan laravel
use Illuminate\Database\Seeder;

class TransactionSaleDetailSeeder extends Seeder
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
            $transactionSaleDetail = new TransactionSaleDetail; //karena memanggil nama model maka harus daftarkan diatas

            $transactionSaleDetail->transaction_id = $i;
            $transactionSaleDetail->product_id = rand(1,25);
            $transactionSaleDetail->qty = rand(1,5);
            $transactionSaleDetail->total = rand(30000,100000);

            $transactionSaleDetail->save();
        }
        for ($e=1; $e < 21; $e++) {
            $transactionSaleDetail = new TransactionSaleDetail; //karena memanggil nama model maka harus daftarkan diatas

            $transactionSaleDetail->transaction_id = $e;
            $transactionSaleDetail->product_id = rand(25,50);
            $transactionSaleDetail->qty = rand(3,8);
            $transactionSaleDetail->total = rand(30000,100000);

            $transactionSaleDetail->save();
        }
        for ($u=1; $u < 21; $u++) {
            $transactionSaleDetail = new TransactionSaleDetail; //karena memanggil nama model maka harus daftarkan diatas

            $transactionSaleDetail->transaction_id = $u;
            $transactionSaleDetail->product_id = rand(50,88);
            $transactionSaleDetail->qty = rand(5,9);
            $transactionSaleDetail->total = rand(30000,100000);

            $transactionSaleDetail->save();
        }
    }
}
