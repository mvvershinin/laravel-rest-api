<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $services = [
        'Category',
        'Product'
    ];

    protected $repositories = [
        'Category',
        'Product'
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->repositories = array_unique($this->repositories);
        foreach ($this->repositories as $repository) {
            $this->app->bind(
                "App\Repositories\Interfaces\\{$repository}RepositoryInterface",
                "App\Repositories\\{$repository}Repository"
            );
        }
        $this->services = array_unique($this->services);
        foreach (array_unique($this->services) as $service) {
            $this->app->bind(
                "App\Services\Interfaces\\{$service}ServiceInterface",
                "App\Services\\{$service}Service"
            );
        }
    }
}
