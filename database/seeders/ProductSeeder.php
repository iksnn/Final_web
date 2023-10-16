<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 20; $i++) {
            Product::create([
                'id_kategori' => rand(1, 3),
                'id_subkategori' => rand(1, 5),
                'nama_barang' => 'Lorem Ipsum Set',
                'gambar' => 'shop_image_'. $i . 'jpg',
                'deskripsi' => 'Lorem Ipsum Set',
                'harga' => rand(1000,2000000),
                'diskon' => 0,
                'bahan' => 'Lorem Ipsum Set',
                'tags' => 'Lorem,Ipsum,Set',
                'sku' => Str::random(8),
                'ukuran' => 'S,M,L,XL,XXL,XXXL',
                'warna' => 'Hitam,Putih,Biru,Merah,Hijau',
            ]);
        }
    }
}
