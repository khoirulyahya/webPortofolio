<?php

namespace Database\Seeders;

use App\Models\Supplier; //memanggil model
use Faker\Factory as Faker; //memanggil plugin bawaan laravel
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $char = date("Ymd");
        for ($i=1; $i < 21; $i++) {
            $supplier = new Supplier; //karena memanggil nama model maka harus daftarkan diatas

            $supplier->supplier_code = 'SPL'.$char.sprintf("%04s",$i);
            $supplier->name = $faker->randomElement($array = array ('PT.', 'CV.')).$faker->domainWord;
            $supplier->phone_number = '08'.rand(1,3).$faker->randomNumber(9);
            $supplier->address = $faker->address;
            $supplier->email = $faker->companyEmail;

            $supplier->save();
        }
    }
}
