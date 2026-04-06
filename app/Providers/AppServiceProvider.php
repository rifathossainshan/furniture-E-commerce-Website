<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Smart image URL helper — serves from uploads/ or storage/ depending on where the file exists
        Blade::directive('simg', function ($path) {
            return "<?php echo (function(\$p) { if (!\$p) return ''; \$u = public_path('uploads/' . \$p); \$s = public_path('storage/' . \$p); if (file_exists(\$u)) return asset('uploads/' . \$p); if (file_exists(\$s)) return asset('storage/' . \$p); return asset('uploads/' . \$p); })($path); ?>";
        });
    }
}
