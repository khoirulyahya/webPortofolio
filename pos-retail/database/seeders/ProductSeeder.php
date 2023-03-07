<?php

namespace Database\Seeders;

use App\Models\Product; //memanggil model
use Faker\Factory as Faker; //memanggil plugin bawaan laravel
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $char = date("Ym");
        $produk12_CTG01 = ["INDOMIE GORENG","INDOMIE SOTO","INDOMIE AYAM BAWANG","INDOMIE AYAM SPESIAL","INDOMIE KARI AYAM","MIE SEDAP GORENG","MIE SEDAP SOTO","MIE SEDAP AYAM BAWANG","MIE SEDAP KARI AYAM","SUPERMI GOKAR","SUPERMI GOSO","SUPERMI GOBANG"];
        $produk12_CTG02 = ["Arinda","Aqua gelas","Aqua Mini","AQUA Galon","Ale-ale","AQUA 1500ML","ABC Squash Delight 600 ml","AQUA 600 ml","JAHE MERAH AMANAH","BIG COLA","Coca cola sedang","Extrajoss"];
        $produk03_CTG03 = ["Roma Kelapa", "Hatari", "Malkist"];
        $produk20_CTG04 = ["BISKUAT BOLU","BENG BENG 20GR","BETTER ROMA","BIG BABOL 3PCS","BISKUAT COKLAT 20GR","BISKUAT ENERGI 22.5GR","BISKUAT SUSU 21GR","BALLET TWIST","CHO CHO","HOQI CHOQI","CHIKI BALLS","CHEWEEZ","CANNON BALL","CHOKIPERO STICK","CHACA","DUA KELINCI KACANG 250 gr","ESPRESSO KOPI SUSU","ESCADO","FULLO","FRENCH FRIES"];
        $produk13_CTG05 = ["BIORE HEALTHY PLUS 250ML","BIORE DAILY ANTISEPTIC 250ML","BIORE ACTIVE DEODORANT 250ML","BIORE PURE MILD 250ML","BIORE WHITENING SCRUB 250ML","BIORE ENERGIZING COOL 250ML","LIFEBUOY NATURE PURE 250ML","LIFEBUIY TOTALPROTECT 250ML","LIFEBUOY MILDCARE 250ML","LIFEBUOY ACTIFRESH","LUX MAGIC SPELL 250ML","LUX POWER ME UP 250ML","LUX WAKE ME UP 250ML"];
        $produk13_CTG06 = ["RINSO ANTI NODA 900G ","RINSO MOLTO 900G ","ATTACK EASY 900G ","ATTACK SOFTENER 900G ","ATTACK MAXIMIZER 900G ","ATTACK COLOUR 900G ","SURF CLEAN FRESH 900G ","SURF LEMON FRESH 900G ","BUKRIM 5000 MERAH550G","BUKRIM 5000 LEMON 550G","WOW FRESH LIME 550G","WOW EXOTIC FLOWER 550G","WOW SEJUTA BUNGA 550G"];
        $produk02_CTG07 = ["BRIGHT GAS 3 kg","BRIGHT GAS 12 kg"];
        $produk03_CTG08 = ["Bulpen A1","PENSIL 2B","Buku Note A5s"];
        $produk10_CTG09 = ["ADEM SARI","ALANGSARI","ANAKONIDIN","ANTANGIN JRG SIRUP","ANTANGIN JRG TABLET","ANTIMO ANAK SIROP","ANTIMO TABLET","AMANPLAST","ANAK SUMANG","BABY'S COUGH SYRUP"];
        // $productList = ["Bahan Makanan Pokok", "Minuman", "Roti Kering dan basah", "Snack", "Perawatan tubuh", "Bahan dan peralatan cuci", "Bahan dan peralatan perawatan rumah", "Alat tulis dan kantor", "Obat-obatan"];
        for ($o=1; $o < 13; $o++) {
            $product1 = new Product; //karena memanggil nama model maka harus daftarkan diatas

            $product1->product_code = 'BRG'.$char.'CTG'.sprintf("%03s",$o);
            // $product->name = $faker->lexify;
            $product1->name = $produk12_CTG01[$o-1];
            $product1->category_id = '1';
            $product1->qty = rand(20,50);
            $product1->unit = $faker->randomElement($array = array ('Item', 'Pcs', 'Lusin', 'Karton', 'Box'));
            $product1->buy_price = rand(20000,24000);
            $product1->member_price = rand(24500,25500);
            $product1->retail_price = rand(25800,27500);

            $product1->save();
        }
        for ($i=1; $i < 13; $i++) {
            $product2 = new Product; //karena memanggil nama model maka harus daftarkan diatas

            $product2->product_code = 'BRG'.$char.'CTG'.sprintf("%03s",$i+12);
            // $product->name = $faker->lexify;
            $product2->name = $produk12_CTG02[$i-1];
            $product2->category_id = '2';
            $product2->qty = rand(20,50);
            $product2->unit = $faker->randomElement($array = array ('Item', 'Pcs', 'Lusin', 'Karton', 'Box'));
            $product2->buy_price = rand(20000,24000);
            $product2->member_price = rand(24500,25500);
            $product2->retail_price = rand(25800,27500);

            $product2->save();
        }
        for ($u=1; $u < 4; $u++) {
            $product3 = new Product; //karena memanggil nama model maka harus daftarkan diatas

            $product3->product_code = 'BRG'.$char.'CTG'.sprintf("%03s",$u+24);
            // $product->name = $faker->lexify;
            $product3->name = $produk03_CTG03[$u-1];
            $product3->category_id = '3';
            $product3->qty = rand(20,50);
            $product3->unit = $faker->randomElement($array = array ('Item', 'Pcs', 'Lusin', 'Karton', 'Box'));
            $product3->buy_price = rand(20000,24000);
            $product3->member_price = rand(24500,25500);
            $product3->retail_price = rand(25800,27500);

            $product3->save();
        }
        for ($y=1; $y < 21; $y++) {
            $product4 = new Product; //karena memanggil nama model maka harus daftarkan diatas

            $product4->product_code = 'BRG'.$char.'CTG'.sprintf("%03s",$y+27);
            // $product->name = $faker->lexify;
            $product4->name = $produk20_CTG04[$y-1];
            $product4->category_id = '4';
            $product4->qty = rand(20,50);
            $product4->unit = $faker->randomElement($array = array ('Item', 'Pcs', 'Lusin', 'Karton', 'Box'));
            $product4->buy_price = rand(20000,24000);
            $product4->member_price = rand(24500,25500);
            $product4->retail_price = rand(25800,27500);

            $product4->save();
        }
        for ($t=1; $t < 14; $t++) {
            $product5 = new Product; //karena memanggil nama model maka harus daftarkan diatas

            $product5->product_code = 'BRG'.$char.'CTG'.sprintf("%03s",$t+47);
            // $product->name = $faker->lexify;
            $product5->name = $produk13_CTG05[$t-1];
            $product5->category_id = '5';
            $product5->qty = rand(20,50);
            $product5->unit = $faker->randomElement($array = array ('Item', 'Pcs', 'Lusin', 'Karton', 'Box'));
            $product5->buy_price = rand(20000,24000);
            $product5->member_price = rand(24500,25500);
            $product5->retail_price = rand(25800,27500);

            $product5->save();
        }
        for ($r=1; $r < 14; $r++) {
            $product6 = new Product; //karena memanggil nama model maka harus daftarkan diatas

            $product6->product_code = 'BRG'.$char.'CTG'.sprintf("%03s",$r+60);
            // $product->name = $faker->lexify;
            $product6->name = $produk13_CTG06[$r-1];
            $product6->category_id = '6';
            $product6->qty = rand(20,50);
            $product6->unit = $faker->randomElement($array = array ('Item', 'Pcs', 'Lusin', 'Karton', 'Box'));
            $product6->buy_price = rand(20000,24000);
            $product6->member_price = rand(24500,25500);
            $product6->retail_price = rand(25800,27500);

            $product6->save();
        }
        for ($e=1; $e < 3; $e++) {
            $product7 = new Product; //karena memanggil nama model maka harus daftarkan diatas

            $product7->product_code = 'BRG'.$char.'CTG'.sprintf("%03s",$e+73);
            // $product->name = $faker->lexify;
            $product7->name = $produk02_CTG07[$e-1];
            $product7->category_id = '7';
            $product7->qty = rand(20,50);
            $product7->unit = $faker->randomElement($array = array ('Item', 'Pcs', 'Lusin', 'Karton', 'Box'));
            $product7->buy_price = rand(20000,24000);
            $product7->member_price = rand(24500,25500);
            $product7->retail_price = rand(25800,27500);

            $product7->save();
        }
        for ($w=1; $w < 4; $w++) {
            $product8 = new Product; //karena memanggil nama model maka harus daftarkan diatas

            $product8->product_code = 'BRG'.$char.'CTG'.sprintf("%03s",$w+75);
            // $product->name = $faker->lexify;
            $product8->name = $produk03_CTG08[$w-1];
            $product8->category_id = '8';
            $product8->qty = rand(20,50);
            $product8->unit = $faker->randomElement($array = array ('Item', 'Pcs', 'Lusin', 'Karton', 'Box'));
            $product8->buy_price = rand(20000,24000);
            $product8->member_price = rand(24500,25500);
            $product8->retail_price = rand(25800,27500);

            $product8->save();
        }
        for ($q=1; $q < 11; $q++) {
            $product9 = new Product; //karena memanggil nama model maka harus daftarkan diatas

            $product9->product_code = 'BRG'.$char.'CTG'.sprintf("%03s",$q+78);
            // $product->name = $faker->lexify;
            $product9->name = $produk10_CTG09[$q-1];
            $product9->category_id = '9';
            $product9->qty = rand(20,50);
            $product9->unit = $faker->randomElement($array = array ('Item', 'Pcs', 'Lusin', 'Karton', 'Box'));
            $product9->buy_price = rand(20000,24000);
            $product9->member_price = rand(24500,25500);
            $product9->retail_price = rand(25800,27500);

            $product9->save();
        }

    }
}
