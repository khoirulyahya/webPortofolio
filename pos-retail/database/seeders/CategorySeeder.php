<?php

namespace Database\Seeders;

use App\Models\Category; //memanggil model
use Faker\Factory as Faker; //memanggil plugin bawaan laravel
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
        $department = ["Bahan Makanan Pokok", "Minuman", "Roti Kering dan basah", "Snack", "Perawatan tubuh", "Bahan dan peralatan cuci", "Bahan dan peralatan perawatan rumah", "Alat tulis dan kantor", "Obat-obatan"];
        for ($i=1; $i < 10; $i++) {
            $category = new Category; //karena memanggil nama model maka harus daftarkan diatas

            $category->category_code = 'CTG'.$char.sprintf("%04s",$i);
            $category->name = $department[$i-1];

            $category->save();
        }
    }
}
