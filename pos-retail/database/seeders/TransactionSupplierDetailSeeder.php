<?php

namespace Database\Seeders;

use App\Models\TransactionSupplierDetail; //memanggil model
use Faker\Factory as Faker; //memanggil plugin bawaan laravel
use Illuminate\Database\Seeder;

class TransactionSupplierDetailSeeder extends Seeder
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
            $transactionSupplierDetail = new TransactionSupplierDetail; //karena memanggil nama model maka harus daftarkan diatas

            $transactionSupplierDetail->transaction_id = $i;
            $transactionSupplierDetail->product_id = rand(1,25);
            $transactionSupplierDetail->qty = rand(10,50);
            $transactionSupplierDetail->total = rand(300000,1000000);

            $transactionSupplierDetail->save();
        }
        for ($e=1; $e < 21; $e++) {
            $transactionSupplierDetail = new TransactionSupplierDetail; //karena memanggil nama model maka harus daftarkan diatas

            $transactionSupplierDetail->transaction_id = $e;
            $transactionSupplierDetail->product_id = rand(25,50);
            $transactionSupplierDetail->qty = rand(30,80);
            $transactionSupplierDetail->total = rand(300000,1000000);

            $transactionSupplierDetail->save();
        }
        for ($u=1; $u < 21; $u++) {
            $transactionSupplierDetail = new TransactionSupplierDetail; //karena memanggil nama model maka harus daftarkan diatas

            $transactionSupplierDetail->transaction_id = $u;
            $transactionSupplierDetail->product_id = rand(50,88);
            $transactionSupplierDetail->qty = rand(50,90);
            $transactionSupplierDetail->total = rand(300000,1000000);

            $transactionSupplierDetail->save();
        }
    }
}
