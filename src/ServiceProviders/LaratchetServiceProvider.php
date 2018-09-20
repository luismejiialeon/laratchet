<?php
namespace SysMl\Laratchet\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class LaratchetServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

        $configPath = __DIR__ . '/../Config/laratchet.php';
        $this->mergeConfigFrom($configPath, 'laratchet');

		$this->app['laratchet'] = $this-> app -> share(function($app){

            return new \SysMl\Laratchet\Laratchet();
        });

        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Laratchet', '\SysMl\Laratchet\Facades\LaratchetFacade');
        });

        $this->app->singleton('command.sysMl.laratchetserver', function ($app) {
            return $app['SysMl\Laratchet\Commands\LaRatchetServer'];
        });

        $this->commands('command.sysMl.laratchetserver');


	}


    /**
     * The boot method
     */
    public function boot()
    {

        require(__DIR__ . '/../routes.php');

        require(__DIR__ . '/../filters.php');

        $configPath = __DIR__ . '/../Config/laratchet.php';
        $this->publishes([$configPath => config_path('laratchet.php')], 'config');

        $this->loadViewsFrom(__DIR__.'/../Views', 'laratchet');

        $this->publishes([
            __DIR__.'/../Views' => base_path('resources/views/vendor/laratchet'),
        ]);

        $this->publishes([
            __DIR__.'/../Migrations/' => database_path('/migrations')
        ], 'migrations');

    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
