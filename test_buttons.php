<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$product = App\Models\Product::with('category')->find(11);
$btnType = $product->category->button_type ?? 'buy_now';
echo "Product: {$product->name}\n";
echo "Category: " . ($product->category->name ?? 'None') . "\n";
echo "Button Type: {$btnType}\n";

$cat = App\Models\Category::find(12);
$product2 = App\Models\Product::create(['name' => 'Test Event', 'slug' => 'test-event-1', 'category_id' => $cat->id, 'price' => 100, 'stock' => 10, 'status' => 1]);

$product2 = App\Models\Product::with('category')->find($product2->id);
$btnType2 = $product2->category->button_type ?? 'buy_now';
echo "Product 2: {$product2->name}\n";
echo "Category 2: " . ($product2->category->name ?? 'None') . "\n";
echo "Button Type 2: {$btnType2}\n";

$html = view('shop', ['products' => App\Models\Product::with('category')->paginate(16), 'categories' => App\Models\Category::all(), 'selectedCategory' => null])->render();
if (strpos($html, 'Send Inquiry') !== false) {
    echo "Send Inquiry found in HTML\n";
} else {
    echo "Send Inquiry NOT found\n";
}
