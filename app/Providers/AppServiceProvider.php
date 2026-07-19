<?php

namespace App\Providers;

use App\Models\ContactMessage;
use App\Observers\ContactMessageObserver;
use App\View\Composers\FrontendLayoutComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
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
        ContactMessage::observe(ContactMessageObserver::class);

        View::composer('layouts.frontend', FrontendLayoutComposer::class);

        Blade::directive('svg', function (string $expression) {
            return "<?php echo \$__env->make('components.icon', ['name' => {$expression}, 'attributes' => new \\Illuminate\\View\\ComponentAttributeBag()])->render(); ?>";
        });
    }
}
