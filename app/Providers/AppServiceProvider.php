<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Carbon\Carbon;

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
        // Helper function untuk format waktu WIB
        \Blade::directive('wibTime', function ($expression) {
            return "<?php echo \\Carbon\\Carbon::parse($expression)->timezone('Asia/Jakarta')->format('d-m-Y H:i'); ?>";
        });
        
        \Blade::directive('wibDate', function ($expression) {
            return "<?php echo \\Carbon\\Carbon::parse($expression)->timezone('Asia/Jakarta')->format('d-m-Y'); ?>";
        });

        // Share notifikasi dan jumlah unread ke semua view
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $notifications = Notification::where('user_id', $userId)
                    ->orderByDesc('created_at')
                    ->limit(10)
                    ->get();
                $unreadCount = Notification::where('user_id', $userId)
                    ->whereNull('read_at')
                    ->count();
                $view->with(compact('notifications', 'unreadCount'));
            }
        });
    }
}
