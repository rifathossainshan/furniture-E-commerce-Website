<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$category = \App\Models\Category::where('name', 'Footwear')->first();
if ($category) {
    try {
        $result = $category->delete();
        echo "Deleted function returned: " . (int)$result . "\n";
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "Category not found\n";
}
