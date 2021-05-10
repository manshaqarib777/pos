<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
                    'App\Category' => 'App\Policies\CategoryPolicy',
                    'App\Subcategory' => 'App\Policies\SubcategoryPolicy',
                    'App\Customer' => 'App\Policies\CustomerPolicy',
                    'App\Product' => 'App\Policies\ProductPolicy',
                    'App\Supplier' => 'App\Policies\SupplierPolicy',
                    'App\Tax' => 'App\Policies\TaxPolicy',
                    'App\Warehouse' => 'App\Policies\WarehousePolicy',
                    'App\User'  => 'App\Policies\UserPolicy',
                    'App\Group' => 'App\Policies\GroupPolicy',
                    'App\Sale' => 'App\Policies\SalePolicy',
                    'App\Refund' => 'App\Policies\RefundPolicy',
                    'App\Setting' => 'App\Policies\MasterPolicy',
                    'App\Chapter' => 'App\Policies\ChapterPolicy',
                    'App\UserActivity' => 'App\Policies\LogsPolicy',
                    'App\Report' => 'App\Policies\ReportsPolicy',
                    'App\Payment' => 'App\Policies\PaymentPolicy',
                 ];

    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
        //Permissions Allowed to Master User
        Gate::before(
            function ($user) {
                if ($user->id === 1) {
                    return true;
                }
            }
        );
    }
}
