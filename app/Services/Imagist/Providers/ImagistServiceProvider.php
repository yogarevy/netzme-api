<?php


namespace App\Services\Imagist\Providers;


use App\Services\Imagist\Imagist;
use App\Services\Imagist\Repositories\ImagistRepository;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ImagistServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerService();
    }

    /**
     * Bootstrap services.
     *
     * @param Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $this->publishConfig();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'imagist',
            'imagist.facade',
            'imagist.image',
        ];
    }

    /**
     * Register service class.
     */
    protected function registerService()
    {
        $this->app->singleton('imagist.image', function () {
            return new ImagistRepository();
        });
        $this->registerFacades();
    }


    /**
     * registering facades
     */
    protected function registerFacades()
    {
        $this->app->singleton('imagist.facade', function ($app) {
            return new Imagist(
                $app,
                $app['imagist.image']
            );
        });
    }

    /**
     * publish config
     */
    private function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/imagist.php' => config_path('imagist.php')
        ], 'config');
    }
}
