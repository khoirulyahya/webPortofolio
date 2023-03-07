<?php

namespace Database\Seeders;

use App\Models\Member; //memanggil model
use Faker\Factory as Faker; //memanggil plugin bawaan laravel
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
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
            $member = new Member; //karena memanggil nama model maka harus daftarkan diatas

            $member->member_code = 'MBR'.$char.sprintf("%04s",$i);
            $member->name = $faker->name;
            $member->phone_number = '082'.$faker->randomNumber(9);

            $member->save();
        }
    }
}
