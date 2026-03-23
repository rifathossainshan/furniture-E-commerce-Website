<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Settings
        $settings = [
            'site_name' => 'MUSFIQ',
            'notice_text' => 'FREE GLOBAL SHIPPING ON ORDERS OVER $500. [SHOP NOW]',
            'notice_active' => '1',
            'about_us' => 'Musfiq is a concept store redefining modern elegance and minimalist fashion.',
            'contact_email' => 'hello@musfiq.com',
            'contact_phone' => '+1 (555) 123-4567',
        ];
        foreach ($settings as $key => $value) {
            Setting::create(['key' => $key, 'value' => $value]);
        }

        // Users
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
        User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        // Sliders
        Slider::create([
            'title' => "ELEGANZ\nREDEFINED.",
            'subtitle' => 'Discover our Spring/Summer 2026 Collection.',
            'button_text' => 'SHOP NEW ARRIVALS',
            'button_link' => '/shop',
            'image' => 'sliders/demo.jpg',
            'status' => true
        ]);

        // Categories
        $categories = ['Formal Wear', 'Casual', 'Accessories', 'Footwear'];
        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
                'image' => 'categories/demo.jpg',
                'status' => true
            ]);
        }

        // Products
        for ($i = 1; $i <= 8; $i++) {
            Product::create([
                'category_id' => rand(1, 4),
                'name' => 'Premium Collection Item ' . $i,
                'slug' => 'premium-collection-item-' . $i,
                'description' => 'A beautifully crafted piece for your everyday elegance.',
                'price' => rand(99, 499) + 0.99,
                'stock' => rand(10, 50),
                'image' => 'products/demo.jpg',
                'is_featured' => $i <= 4,
                'status' => true
            ]);
        }

        // Voucher
        Voucher::create([
            'code' => 'WELCOME10',
            'type' => 'percent',
            'amount' => 10,
            'status' => true
        ]);
    }
}
