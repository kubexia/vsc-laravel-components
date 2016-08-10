<?php
namespace VSC;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider {
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    
    protected $packageName = 'vsc-laravel-components';
    
    public function boot() {
        $this->handleConfigs();
        
        $this->handleViews();
        
        $this->handleTranslations();
        
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        // Bind any implementations.
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [];
    }
    
    private function handleConfigs() {
        $configPath = __DIR__ . '/../config/'.$this->packageName.'.php';
        
        $this->publishes([
            $configPath => config_path($this->packageName.'.php')
        ],'configs');
        
        $this->mergeConfigFrom($configPath, $this->packageName);
    }
    
    private function handleTranslations() {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', $this->packageName);
        
        $this->publishes([
            __DIR__.'/../resources/lang' => base_path('resources/lang/vendor/'.$this->packageName)
        ],'translations');
    }
    
    private function handleViews() {
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->packageName);
        
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/'.$this->packageName)
        ],'views');
        
    }
    
}