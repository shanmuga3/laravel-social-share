<?php

/**
 * This file is part of Social Share,
 *
 * @license     MIT
 * @package     Shanmuga\SocialShare
 * @category    Provider
 * @author      Shanmugarajan
 */

namespace Shanmuga\SocialShare;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Shanmuga\SocialShare\Library\SocialShare;

class SocialShareServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/social_share.php' => config_path('social_share.php'),
        ],'SocialShare');

        $this->loadViewsFrom(__DIR__.'/views', 'social_share');

        if (class_exists('\Blade')) {
            $this->registerBladeDirectives();
        }
    }

    /**
     * Register the blade directives
     *
     * @return void
     */
    protected function registerBladeDirectives()
    {
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/social_share.php', 'social_share.php'
        );

        $this->app->bind('SocialShare', function ($app) {
            return new SocialShare($app);
        });

        $this->app->alias('SocialShare', 'Shanmuga\SocialShare\Facades\SocialShareFacade');
    }
}