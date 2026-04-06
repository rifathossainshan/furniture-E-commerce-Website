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

        // @simg($path) → asset($path)
        // DB stores the full relative path: "uploads/products/abc.jpg"
        // asset() converts it to the full public URL.
        Blade::directive('simg', function ($path) {
            return "<?php echo $path ? asset($path) : ''; ?>";
        });
    }
}
