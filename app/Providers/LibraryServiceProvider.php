<?php

namespace App\Providers;

use App\Library\Utils\Factory;
use App\Library\Utils\LibraryFactory;
use App\Library\Utils\LibraryManager;
use Illuminate\Support\ServiceProvider;

class LibraryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        require app_path('Library/Libs/helper.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('LibraryManager', function($app) {
            return new LibraryManager($app);
        });
    }

}
