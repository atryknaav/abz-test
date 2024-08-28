<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind('path.public', function() {
            return base_path().'/../public_html';
        });

        Blade::directive('viteDefer', function ($expression) {
            return "<?php echo '<script type=\"module\" src=\"' . Vite::asset($expression) . '\" defer></script>'; ?>";
        });
    }
}
