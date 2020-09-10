<?php

namespace AwemaPL\SystemNotify;

use AwemaPL\SystemNotify\Notify;
use AwemaPL\BaseJS\AwemaProvider;
use Illuminate\Support\Facades\Blade;

class SystemNotifyServiceProvider extends AwemaProvider
{
    public function boot()
    {
        $this->registerHelpers();

        $this->registerDirectives();

        parent::boot();
    }

    public function register()
    {
        $this->app->bind('awema-pl_system-notify', Notify::class);

        parent::register();
    }

    public function getPackageName(): string
    {
        return 'system-notify';
    }

    public function getPath(): string
    {
        return __DIR__;
    }

    protected function registerDirectives()
    {
        $directives = [
            'notify' => 'notify.notification',
        ];

        foreach ($directives as $key => $value) {
            Blade::directive($key, function ($expression) use ($value) {
                if (empty($expression)) {
                    $expression = '[]';
                };
                return '<?php echo view(\'system-notify::components.' . $value . '\', ' . $expression . ')->render(); ?>';
            });
        }
    }

    /**
     * Register helpers file
     */
    public function registerHelpers()
    {
        // Load the helpers in src/functions.php
        if (file_exists($file = __DIR__ . '/helpers.php')) {
            require $file;
        }
    }
}
