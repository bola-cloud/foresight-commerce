<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

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
    public function boot()
    {
        // Check if the 'categories' table exists before querying
        if (Schema::hasTable('categories')) {
            // If the 'order' column exists, fetch ordered by it; otherwise fetch normally.
            if (Schema::hasColumn('categories', 'order')) {
                $categories = Category::orderBy('order', 'asc')->get();
            } else {
                $categories = Category::get();
            }

            View::share('categories', $categories);
        }
    }
}
