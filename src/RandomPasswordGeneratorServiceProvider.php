<?php

namespace LoopLinguist\RandomPasswordGenerator;

use Illuminate\Support\ServiceProvider;

class RandomPasswordGeneratorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/random-password-generator.php',
            'random-password-generator'
        );
        $this->publishes([
            __DIR__ . '/config/random-password-generator.php' => config_path('random-password-generator.php')
        ], 'random-password-generator-config');
    }

    public function register()
    {
    }
}
