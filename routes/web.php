<?php
Route::get(
    '/',
    function () {
        return redirect(route('home'));
    }
);
Route::get('/lang-{lang}.js', 'Controller@lang')->name('lang');

Auth::routes();
Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::get('/home', 'HomeController@index')
            ->name('home');
        Route::get('/dashboard', 'HomeController@dashboard')
            ->name('dashboard');
        Route::post('/quick/mail', 'HomeController@quickMail')
            ->name('quick-mail');
        //label
        Route::post('/product/label', 'ProductAxillaryController@label')
            ->name('product.label');

        //report
        Route::get('/report/inventory', 'ProductReportController@inventory')
            ->name('product.inventory');
        Route::get('/report/cost', 'PurchaseReportController@purchaseReport')
            ->name('cost.report');
        Route::post('/report/cost/generate', 'PurchaseReportController@generateReport')
            ->name('cost.gen');

        Route::get('/report/sale', 'SaleReportController@saleReport')
            ->name('sale.report');
        Route::post('/report/sale/generate', 'SaleReportController@generateSaleReport')
            ->name('sale.gen');

        Route::get('/report/tax', 'TaxReportController@taxReport')
            ->name('tax.report');
        Route::post('/report/tax/generate', 'TaxReportController@generateReport')
            ->name('tax.gen');
        //setting
        Route::patch('/setting-mail/{setting}', 'SettingController@mail')
            ->name('setting.mail');
        Route::patch('/setting/product-config/{setting}', 'SettingController@product');
        Route::patch('/setting/impect-config/{setting}', 'SettingController@impact');
        Route::patch('/setting/pos-config/{setting}', 'SettingController@pos');

        //finance
        Route::get('/sale/detail', 'SaleReportController@saleSummary')
            ->name('sale.detail');
        Route::get('/expense/detail', 'ExpenseReportController@expenseSummary')
            ->name('expense.detail');
        Route::get('/purchase/detail', 'PurchaseReportController@detail')
            ->name('purchase.detail');
        Route::get('/tax/detail', 'TaxReportController@taxSummary')
            ->name('tax.detail');
        Route::get('/refund/detail', 'RefundReportController@refundSummary')
            ->name('refund.detail');

        //user permissions
        Route::get('/permission/{permission}/', 'PermissionController@edit')
            ->name('permission.edit');
        Route::patch('/permission/{permission}/', 'PermissionController@update')
            ->name('permission.update');
        Route::post('/group/permission/request', 'GroupAxillaryController@request')
            ->name('group.permission.request');
        Route::get('/group/requests', 'GroupAxillaryController@index')
            ->name('group.requests');
        Route::patch('/group/request/{group}', 'GroupAxillaryController@update')
            ->name('group.update');

        //Imges
        Route::post('/setting/image', 'SettingController@image')
            ->name('setting.image');
        Route::post('/product/image', 'ProductController@image')
            ->name('product.image');
        Route::post('/category/image', 'CategoryController@image')
            ->name('category.image');
        Route::post('/subcategory/image', 'SubcategoryController@image')
            ->name('subcategory.image');
        Route::post('/expense/image', 'ExpenseController@image')
            ->name('expense.image');
        //purchase inventory
        Route::post('/get-products', 'PurchaseOrderController@products');
        Route::post('/qty-change', 'PurchaseOrderController@qtyChange');
        Route::get('/purchase/print/{purchase}', 'PurchaseOrderController@print')
            ->name('purchase.print');
        Route::get('/purchase/paid/{purchase}', 'PurchaseOrderController@paid')
            ->name('purchase.paid');
        Route::get('/purchase/stock/{purchase}', 'PurchaseOrderController@stockUp')
            ->name('purchase.stock-up');
        //Expense
        Route::get('/expense/print/{expense}', 'ExpenseController@print')
            ->name('expense.print');
        //pos

        Route::post('/pos/hold-on', 'PosController@holdOn');
        Route::post('/confirm-sale', 'RefundController@confirmSale');
        Route::get('/category/child/{category}', 'CategoryAxillaryController@child');
        Route::get('/pos/refund/print/{refund}', 'RefundController@print')
            ->name('refund.print');
        Route::get('/pos/refund/print/a4/{refund}', 'RefundController@printA4')
            ->name('refund.printA4');
        Route::post('/show-cart', 'PosController@showCart');
        Route::post('/search-item', 'PosController@search');
        Route::post('/scan-item', 'PosController@scan');
        Route::patch('/cart-change-qty', 'PosController@qtyChange');
        Route::delete('/cart-remove-item/{sale}', 'PosController@remove');
        Route::get('/pos/print/{sale}', 'SaleController@print')
            ->name('print');
        Route::get('/pos/print/a4/{sale}', 'SaleController@printA4')
            ->name('printA4');
        Route::delete('/clear-cart', 'PosController@destroyCart');
        Route::post('/add-cart', 'PosController@add');
        Route::post('/edit-item-cart', 'PosController@itemEdit');
        Route::get('/categories', 'CategoryAxillaryController@categories');
        Route::get('/products', 'ProductController@products');
        Route::get('/taxes', 'TaxController@taxes');
        Route::get('/customers', 'CustomerController@customers');
        Route::get('/view-cart', 'PosController@viewCart');
        //backup
        Route::get('/backup', 'BackupController@index')
            ->name('backup.index');
        Route::get('/backup/load', 'BackupController@loadBackup');
        Route::post('/backup/generate', 'BackupController@generateBackup');
        Route::patch('/backup/restore', 'BackupController@restore');
        Route::post('/backup/remove', 'BackupController@destroy');

        Route::put('/user/{user}/pin', 'UserController@pin')->name('user.pin');
        Route::put('/chapter/close/{chapter}', 'ChapterController@close')->name('chapter.close');
        Route::put('/payment/toggle/{payment}', 'PaymentController@toggle')->name('payment.toggle');

        Route::get('/payment/pos', 'PaymentController@pos');
        Route::get('/chapters/holding/pos', 'ChapterController@pos');
        Route::get('/system/activity/logs', 'UserActivityController@index')->name('logs.index');
        Route::post('/system/activity/update', 'UserActivityController@update')->name('logs.update');
        Route::post('/system/activity/clear-all', 'UserActivityController@clear')->name('logs.clear');

        //resource
        Route::resource('/pos', 'PosController');
        Route::resource('/sale', 'SaleController');
        Route::resource('/refund', 'RefundController');
        Route::resource('/product', 'ProductController');
        Route::resource('/category', 'CategoryController');
        Route::resource('/subcategory', 'SubcategoryController');
        Route::resource('/customer', 'CustomerController');
        Route::resource('/supplier', 'SupplierController');
        Route::resource('/warehouse', 'WarehouseController');
        Route::resource('/expense', 'ExpenseController');
        Route::resource('/purchase', 'PurchaseController');
        Route::resource('/tax', 'TaxController');
        Route::resource('/setting', 'SettingController');
        Route::resource('/user', 'UserController');
        Route::resource('/group', 'GroupController');
        Route::resource('/chapter', 'ChapterController');
        Route::resource('/payment', 'PaymentController');
        Route::resource('/report', 'ReportController');
    }
);
