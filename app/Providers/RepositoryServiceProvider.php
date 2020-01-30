<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
//jan
use App\Repositories\BackendRepository;
use App\Repositories\Interfaces\BackendRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
		$this->app->bind(
            BackendRepositoryInterface::class, 
            BackendRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
