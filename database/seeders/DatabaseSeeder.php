<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Cuma Celal KORKMAZ',
            'email' => 'cumacelal@gmail.com',
            'password' => 
            Hash::make('123456')
            
        ]);
        
        Category::create([
            'name' => 'Giyim',
            'visible' => 1
        ]);
        Category::create([
            'name' => 'Teknoloji',
            'visible' => 1
        ]);
        Category::create([
            'name' => 'Gıda',
            'visible' => 1
        ]);

        Product::create([
            'name' => 'Gömlek',
            'stock' => 100 ,
            'visible' => 1,
            'category_id' => 1,
            'price' => '14.50',

        ]);
        Product::create([
            'name' => 'Kazak',
            'stock' => 4 ,
            'visible' => 1,
            'category_id' => 1,
            'price' => '50.50',

        ]);
        Product::create([
            'name' => 'Bilgisayar',
            'stock' => 50 ,
            'visible' => 1,
            'category_id' => 2,
            'price' => '30000'
        ]);
        Product::create([
            'name' => 'Iphone14',
            'stock' => 10 ,
            'visible' => 1,
            'category_id' => 2,
            'price' => '50000'
        ]);
        Product::create([
            'name' => 'Dondurulmuş Tatlı',
            'visible' => 1,
            'stock' => 20 ,
            'category_id' => 3,
            'price' => '500.00'
        ]);
        Product::create([
            'name' => 'Pizza',
            'visible' => 1,
            'stock' => 30 ,
            'category_id' => 3,
            'price' => '300.30'
        ]);
        Product::create([
            'name' => 'Lahmacum',
            'stock' => 100 ,
            'visible' => 1,
            'category_id' => 3,
            'price' => '20.30'
        ]);

        Order::create([
            'ciid' => '1123',
            'text' => '',
            'customer_id' => 1,
            'total' => 1000 - (1000 * 0.1),
            'discount' => (1000 * 0.1),
            'subtotal' => 1000,
            'status' => 1 ,
            'visible' => 1 ,
        ]);
        Order::create([
            'ciid' => '1124',
            'text' => '',
            'customer_id' => 1,
            'total' => 1000 - (1000 * 0.1),
            'discount' => (1000 * 0.1),
            'subtotal' => '1000',
            'status' => 2 ,
            'visible' => 1 ,
        ]);
        Order::create([
            'ciid' => '1125',
            'text' => '',
            'customer_id' => 1,
            'total' => 1000 - (1000 * 0.1),
            'discount' => (1000 * 0.1),
            'subtotal' => '1000',
            'status' => 3 ,
            'visible' => 1 ,
        ]);
    }
}
