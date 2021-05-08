<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            '*',
            'App\Http\View\Composers\SettingComposer'
        );
        View::composer(
            [
                'entries.product.create',
                'management.products.edit'
            ],
            'App\Http\View\Composers\WarehouseComposer'
        );
        View::composer(
            [
                'entries.subcategory.create',
                'management.subcategories.edit'
            ],
            'App\Http\View\Composers\SubcategoryFormComposer'
        );
        View::composer(
            [
                'entries.purchase.create',
                'entries.product.create',
                'management.products.edit',
            ],
            'App\Http\View\Composers\SupplierComposer'
        );
        View::composer(
            [
                'dashboard',
            ],
            'App\Http\View\Composers\DashboardComposer'
        );
        View::composer(
            [
                'auth.edit',
                'auth.register',
                'auth.list',
                'setting.setting',
                'group.list'
            ],
            'App\Http\View\Composers\GroupsComposer'
        );
        View::composer(
            [
                'portal.chapters.create'
            ],
            'App\Http\View\Composers\UsersComposer'
        );
        View::composer(
            [
                'layouts.pos',
            ],
            'App\Http\View\Composers\OpenedChapterComposer'
        );
        View::composer(
            [
                'setting.setting',
            ],
            'App\Http\View\Composers\UsersComposer'
        );
        View::composer(
            [
                'setting.setting',
                'entries.product.create',
                'entries.purchase.create',
                'management.products.edit',
            ],
            'App\Http\View\Composers\TaxComposer'
        );
        View::composer(
            [
                'setting.setting',
                'entries.product.create',
                'management.products.edit',
            ],
            'App\Http\View\Composers\CategoryComposer'
        );
        View::composer(
            [
                'setting.setting',
            ],
            'App\Http\View\Composers\PaymentComposer'
        );
        View::composer(
            [
                'setting.setting',
            ],
            'App\Http\View\Composers\CustomerComposer'
        );
    }
}
