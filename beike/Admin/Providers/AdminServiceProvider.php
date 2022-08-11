<?php

namespace Beike\Admin\Providers;

use Beike\Models\AdminUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Beike\Admin\View\Components\Filter;
use Beike\Admin\View\Components\Header;
use Beike\Admin\View\Components\Sidebar;
use Beike\Admin\View\Components\Form\Image;
use Beike\Admin\View\Components\Form\Input;
use Beike\Admin\View\Components\Form\Select;
use Beike\Console\Commands\MakeRootAdminUser;
use Beike\Admin\View\Components\Form\InputLocale;
use Beike\Admin\View\Components\Form\SwitchRadio;
use Beike\Admin\View\Components\Form\Textarea;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @throws \Exception
     */
    public function boot()
    {
        load_settings();
        $this->loadRoutesFrom(__DIR__ . '/../Routes/admin.php');

        $uri = request()->getRequestUri();
        $adminName = admin_name();
        if (!Str::startsWith($uri, "/{$adminName}")) {
            return;
        }

        $this->mergeConfigFrom(__DIR__ . '/../../Config/beike.php', 'beike');
        $this->loadViewsFrom(resource_path('/beike/admin/views'), 'admin');

        $this->app->booted(function () {
            $this->loadShareViewData();
        });

        $this->loadViewComponentsAs('admin', [
            'header' => Header::class,
            'sidebar' => Sidebar::class,
            'filter' => Filter::class,
            'form-input-locale' => InputLocale::class,
            'form-switch' => SwitchRadio::class,
            'form-input' => Input::class,
            'form-select' => Select::class,
            'form-image' => Image::class,
            'form-textarea' => Textarea::class,
        ]);

        $this->registerGuard();

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeRootAdminUser::class,
            ]);

            $this->publishResources();
        }

        Config::set('filesystems.disks.catalog', [
            'driver' => 'local',
            'root' => public_path('catalog'),
        ]);

        $this->loadDesignComponents();
    }

    protected function registerGuard()
    {
        Config::set('auth.guards.' . AdminUser::AUTH_GUARD, [
            'driver' => 'session',
            'provider' => 'admin_users',
        ]);

        Config::set('auth.providers.admin_users', [
            'driver' => 'eloquent',
            'model' => AdminUser::class,
        ]);
    }

    protected function publishResources()
    {
        $this->publishes([
            __DIR__ . '/../Database/Seeders/ProductSeeder.php' => database_path('seeders/ProductSeeder.php'),
        ], 'beike-seeders');
    }

    /**
     * 加载首页 page builder 相关组件
     *
     * @throws \Exception
     */
    protected function loadDesignComponents()
    {
        $viewPath = base_path() . '/beike/Admin/View';
        $builderPath = $viewPath . '/DesignBuilders/';

        $builders = glob($builderPath . '*');
        foreach ($builders as $builder) {
            $builderName = basename($builder, '.php');
            $aliasName = Str::snake($builderName);
            $componentName = Str::studly($builderName);
            $classBaseName = "\\Beike\\Admin\\View\\DesignBuilders\\{$componentName}";

            if (!class_exists($classBaseName)) {
                throw new \Exception("请先定义自定义模板类 {$classBaseName}");
            }
            $this->loadViewComponentsAs('editor', [
                $aliasName => $classBaseName
            ]);
        }
    }


    /**
     * 后台公共数据
     */
    protected function loadShareViewData()
    {
        View::share('languages', languages());
        View::share('admin_base_url', admin_route('home.index'));
    }
}
