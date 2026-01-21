<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /* Basic Elements  */
        Blade::component('admin.sidebar',\App\View\Components\Admin\Sidebar::class);
        Blade::component('admin.theme.dropdown',\App\View\Components\Admin\Theme\DropDownButton::class);

        /* Forms Elements  */
        Blade::component('forms.filepond',\App\View\Components\Forms\Filepond::class);
        Blade::component('forms.tag',\App\View\Components\Forms\Tag::class);
        Blade::component('forms.select2',\App\View\Components\Forms\Select2::class);
        Blade::component('forms.select2.ajax',\App\View\Components\Forms\Select2Ajax::class);
        Blade::component('forms.multi-choice-dropdown',\App\View\Components\Forms\MultiChoiceDropdown::class);

    }
}
