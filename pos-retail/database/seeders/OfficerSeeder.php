<?php

namespace Database\Seeders;

use App\Models\Officer; //memanggil model
use Faker\Factory as Faker; //memanggil plugin bawaan laravel
use Illuminate\Database\Seeder;

class OfficerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $char = date("dmY");
        for ($i=1; $i < 21; $i++) {
            $officer = new Officer; //karena memanggil nama model maka harus daftarkan diatas

            $officer->officer_code = 'OFC'.$char.sprintf("%04s",$i);
            $officer->name = $faker->name;
            $officer->phone_number = '08'.rand(1,3).$faker->randomNumber(9);
            $officer->address = $faker->address;

            $officer->save();
        }
    }
}
