<?php

namespace StatamicMave;

use StatamicMave\Tags\MaveTag;
use Statamic\Providers\AddonServiceProvider;
use StatamicMave\Fieldtypes\MaveFieldtype;

class ServiceProvider extends AddonServiceProvider
{
    public function __construct()
    {
        $this->vite['hotFile'] = base_path('vendor/eminos/statamic-mave/dist/vite.hot');

        parent::__construct(app());
    }

    protected $fieldtypes = [
        MaveFieldtype::class,
    ];

    protected $tags = [
        MaveTag::class,
    ];

    protected $vite = [
        'hotFile' => null, // set in the constructor for reasons
        'publicDirectory' => 'dist',
        'input' => [
            'resources/js/mave-fieldtype.js',
            'resources/css/mave-fieldtype.css'
        ],
    ];

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/mave.php', 'mave');
    }

    /**
     * Bootstrap any addon services.
     */
    public function bootAddon()
    {
        $this->publishes([
            __DIR__ . '/../config/mave.php' => config_path('mave.php'),
        ], 'mave-config');
    }
}