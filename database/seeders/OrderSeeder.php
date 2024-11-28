<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Membuat beberapa pengguna dengan alamat Jakarta
        $users = User::factory(10)->create([
            'address' => 'Jakarta',  // Setiap pengguna diberi alamat Jakarta
            'phone' => '0811',
        ]);

        // Membuat order untuk setiap pengguna
        foreach ($users as $user) {
            // Membuat order
            $order = Order::create([
                'order_code' => 'ORD' . strtoupper(Str::random(8)),
                'user_id' => $user->id,
                'total_price' => $faker->randomFloat(2, 100000, 500000),
                'status' => $faker->randomElement(['dibayar', 'sedang diproses', 'dikirim']),
                'alamat_pengiriman' => 'Jakarta',  // Alamat pengiriman juga menggunakan Jakarta
                'midtrans_transaction_id' => $faker->uuid,
                'resi_code' => $faker->word,
            ]);

            // Menambahkan produk ke dalam order
            $products = Product::inRandomOrder()->take(3)->get();  // Ambil 3 produk secara acak

            foreach ($products as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'price' => $product->price,
                ]);
            }
        }
    }
}
