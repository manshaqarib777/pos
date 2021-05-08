<div class="sidebar">
    <div class="sidebar-wrapper scrollbar-inner">
        <div class="sidebar-content">
            <div class="user p-0">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{asset('storage/'.Auth::user()->image)}}" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info" data-toggle="tooltip" title="{{__('sidebar.clickToEditYourInformation')}}">
                    <a href="{{route('user.edit',Auth::user())}}" class="btn-sm">
                        <span class="m-0 p-0">
                            <strong>{{Auth::user()->name}} </strong>
                            <span class="user-level m-0">{{Auth::user()->group->name}}</span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <ul class="nav">
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.homeAndQuickMailingService')}}">
                    <a href="{{route('home')}}">
                        <i class="fas fa-fw text-info fa-home" aria-hidden="true"></i>
                        <p>{{__('sidebar.home')}}</p>
                    </a>
                </li>
                @can('dashboard','App\Setting')
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.dashboardLast10OrdersQuickLinks')}}">
                    <a href="{{route('dashboard')}}">
                        <i class="fas fa-fw text-info fa-tachometer-alt" aria-hidden="true"></i>
                        <p>{{__('sidebar.dashboard')}}</p>
                    </a>
                </li>
                @endcan
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.pos')}}">
                    <a data-toggle="collapse" href="#pos">
                        <i class="fas fa-fw text-info fa-shopping-cart" aria-hidden="true"></i>
                        <p>{{__('sidebar.pos')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="pos">
                        <ul class="nav nav-collapse">
                            <li data-toggle="tooltip" title="{{__('sidebar.goToPointOfSalePortal')}}">
                                <a href="{{route('pos.index')}}" data-toggle="tooltip"  title="{{__('sidebar.switchToPOS')}}">
                                    <span class="sub-item">{{__('sidebar.switchToPOS')}}</span>
                                </a>
                            </li>
                            @can('open','App\Chapter')
                            <li data-toggle="tooltip" title="{{__('sidebar.openNewRegisterCashInHands')}}">
                                <a href="{{route('chapter.create')}}" data-toggle="tooltip" title="{{__('sidebar.openNewSaleRegister')}}">
                                    <span class="sub-item">{{__('sidebar.newRegister')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Chapter')
                            <li data-toggle="tooltip" title="{{__('sidebar.chapterTile')}}">
                                <a href="{{route('chapter.index')}}">
                                    <span class="sub-item">{{__('sidebar.registers')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Sale')
                            <li data-toggle="tooltip" title="{{__('sidebar.saleOrdersManagement')}}">
                                <a href="{{route('sale.index')}}">
                                    <span class="sub-item">{{__('sidebar.manageSales')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Refund')
                            <li data-toggle="tooltip" title="{{__('sidebar.refundOrdersManagement')}}">
                                <a href="{{route('refund.index')}}">
                                    <span class="sub-item">{{__('sidebar.manageRefunds')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.products')}}">
                    <a data-toggle="collapse" href="#products">
                        <i class="fas fa-fw text-info fa-cubes" aria-hidden="true"></i>
                        <p>{{__('sidebar.products')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="products">
                        <ul class="nav nav-collapse" id="entries">
                            @can('create','App\Product')
                            <li>
                                <a href="{{route('product.create')}}" data-toggle="tooltip" title="{{__('sidebar.addNewProduct')}}">
                                    <span class="sub-item">{{__('sidebar.addProduct')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Product')
                            <li>
                                <a href="{{route('product.index')}}" data-toggle="tooltip" title="{{__('sidebar.productsManagement')}}">
                                    <span class="sub-item">{{__('sidebar.productsList')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.categories')}}">
                    <a data-toggle="collapse" href="#category">
                        <i class="fas fa-fw text-info fa-sitemap" aria-hidden="true"></i>
                        <p>{{__('sidebar.categories')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="category">
                        <ul class="nav nav-collapse" id="entries">
                            @can('create','App\Category')
                            <li>
                                <a href="{{route('category.create')}}" data-toggle="tooltip" title="{{__('sidebar.categoryForProducts')}}">
                                    <span class="sub-item">{{__('sidebar.createCategory')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Category')
                            <li>
                                <a href="{{route('category.index')}}" data-toggle="tooltip" title="{{__('sidebar.categoriesManagement')}}">
                                    <span class="sub-item">{{__('sidebar.categoriesList')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.subcategories')}}">
                    <a data-toggle="collapse" href="#subcategory">
                        <i class="fas fa-fw text-info fa-sitemap" aria-hidden="true"></i>
                        <p>{{__('sidebar.subcategories')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="subcategory">
                        <ul class="nav nav-collapse" id="entries">
                            @can('create','App\Subcategory')
                            <li>
                                <a href="{{route('subcategory.create')}}" data-toggle="tooltip" title="{{__('sidebar.subcategoryForProducts')}}">
                                    <span class="sub-item">{{__('sidebar.createSubsategory')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Subcategory')
                            <li>
                                <a href="{{route('subcategory.index')}}" data-toggle="tooltip" title="{{__('sidebar.subcategoriesManagement')}}">
                                    <span class="sub-item">{{__('sidebar.subcategoriesList')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.suppliers')}}">
                    <a data-toggle="collapse" href="#suppliers">
                        <i class="fas fa-fw text-info fa-user-plus" aria-hidden="true"></i>
                        <p>{{__('sidebar.suppliers')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="suppliers">
                        <ul class="nav nav-collapse" id="entries">
                            @can('create','App\Supplier')
                            <li>
                                <a href="{{route('supplier.create')}}" data-toggle="tooltip" title="{{__('sidebar.addNewSupplier')}}">
                                    <span class="sub-item">{{__('sidebar.addSupplier')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Supplier')
                            <li>
                                <a href="{{route('supplier.index')}}"  data-toggle="tooltip" title="{{__('sidebar.suppliersManagement')}}">
                                    <span class="sub-item">{{__('sidebar.suppliersList')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.expenses')}}">
                    <a data-toggle="collapse" href="#expenses">
                        <i class="fas fa-fw text-info fa-minus-circle" aria-hidden="true"></i>
                        <p>{{__('sidebar.expenses')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="expenses">
                        <ul class="nav nav-collapse" id="entries">
                            @can('create','App\Expense')
                            <li>
                                <a href="{{route('expense.create')}}" data-toggle="tooltip" title="{{__('sidebar.addExpenseVoucher')}}">
                                    <span class="sub-item">{{__('sidebar.expenseVoucher')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Expense')
                            <li>
                                <a href="{{route('expense.index')}}"  data-toggle="tooltip" title="{{__('sidebar.expensesManagement')}}">
                                    <span class="sub-item">{{__('sidebar.expensesList')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.suppliers')}}">
                    <a data-toggle="collapse" href="#customers">
                        <i class="fas fa-fw text-info fa-user" aria-hidden="true"></i>
                        <p>{{__('sidebar.customers')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="customers">
                        <ul class="nav nav-collapse" id="entries">
                            @can('create','App\Customer')
                            <li>
                                <a href="{{route('customer.create')}}" data-toggle="tooltip" title="{{__('sidebar.addNewCustomer')}}">
                                    <span class="sub-item">{{__('sidebar.addCustomer')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Customer')
                            <li>
                                <a href="{{route('customer.index')}}"  data-toggle="tooltip" title="{{__('sidebar.customersManagement')}}">
                                    <span class="sub-item">{{__('sidebar.customersList')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.payments')}}">
                    <a data-toggle="collapse" href="#payments">
                        <i class="fas fa-fw text-info fa-money-bill" aria-hidden="true"></i>
                        <p>{{__('sidebar.payments')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="payments">
                        <ul class="nav nav-collapse" id="entries">
                            @can('create','App\Payment')
                            <li>
                                <a href="{{route('payment.create')}}" data-toggle="tooltip" title="{{__('sidebar.definePaymentGateway')}}">
                                    <span class="sub-item">{{__('sidebar.newPaymentGateway')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Payment')
                            <li>
                                <a href="{{route('payment.index')}}"  data-toggle="tooltip" title="{{__('sidebar.paymentsManagement')}}">
                                    <span class="sub-item">{{__('sidebar.payments')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.warehouses')}}">
                    <a data-toggle="collapse" href="#warehouses">
                        <i class="fas fa-fw text-info fa-warehouse" aria-hidden="true"></i>
                        <p>{{__('sidebar.warehouses')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="warehouses">
                        <ul class="nav nav-collapse" id="warehouses">
                            @can('create','App\Warehouse')
                            <li>
                                <a href="{{route('warehouse.create')}}" data-toggle="tooltip" title="{{__('sidebar.registerNewWarehouse')}}">
                                    <span class="sub-item">{{__('sidebar.registerWarehouse')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Warehouse')
                            <li>
                                <a href="{{route('warehouse.index')}}"  data-toggle="tooltip" title="{{__('sidebar.warehousesManagement')}}">
                                    <span class="sub-item">{{__('sidebar.warehousesList')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.purchases')}}">
                    <a data-toggle="collapse" href="#purchases">
                        <i class="fas fa-fw text-info fa-th-large" aria-hidden="true"></i>
                        <p>{{__('sidebar.purchases')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="purchases">
                        <ul class="nav nav-collapse" id="purchases">
                            @can('create','App\Purchase')
                            <li>
                                <a href="{{route('purchase.create')}}" data-toggle="tooltip" title="{{__('sidebar.makePurchase')}}">
                                    <span class="sub-item">{{__('sidebar.makePurchase')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Purchase')
                            <li>
                                <a href="{{route('purchase.index')}}"  data-toggle="tooltip" title="{{__('sidebar.purchasesManagement')}}">
                                    <span class="sub-item">{{__('sidebar.purchaseOrders')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.taxes')}}">
                    <a data-toggle="collapse" href="#taxes">
                        <i class="fas fa-fw text-info fa-percent" aria-hidden="true"></i>
                        <p>{{__('sidebar.taxes')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="taxes">
                        <ul class="nav nav-collapse" id="taxes">
                            @can('create','App\Tax')
                            <li>
                                <a href="{{route('tax.create')}}" data-toggle="tooltip" title="{{__('sidebar.defineNewTax')}}">
                                    <span class="sub-item">{{__('sidebar.defineTax')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Tax')
                            <li>
                                <a href="{{route('tax.index')}}"  data-toggle="tooltip" title="{{__('sidebar.taxesManagement')}}">
                                    <span class="sub-item">{{__('sidebar.taxes')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item"  data-toggle="tooltip" title="{{__('sidebar.resourceCharts')}}">
                    <a data-toggle="collapse" href="#tables">
                        <i class="fas fa-fw text-info fa-money-check-alt" aria-hidden="true"></i>
                        <p>{{__('sidebar.financeCharts')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="tables">
                        <ul class="nav nav-collapse" id="finance" >
                            @can('summary','App\Sale')
                            <li  data-toggle="tooltip" title="{{__('sidebar.annualSaleChart')}}">
                                <a href="{{route('sale.detail')}}">
                                    <span class="sub-item">{{__('sidebar.annualSaleChart')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('summary','App\Refund')
                            <li data-toggle="tooltip" title="{{__('sidebar.annualRefundChart')}}">
                                <a href="{{route('refund.detail')}}">
                                    <span class="sub-item">{{__('sidebar.annualRefundChart')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('summary','App\Expense')
                            <li data-toggle="tooltip" title="{{__('sidebar.annualExpenseChart')}}">
                                <a href="{{route('expense.detail')}}">
                                    <span class="sub-item">{{__('sidebar.annualExpenseChart')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('summary','App\Purchase')
                            <li data-toggle="tooltip" title="{{__('sidebar.annualPurchaseChart')}}">
                                <a href="{{route('purchase.detail')}}">
                                    <span class="sub-item">{{__('sidebar.annualPurchaseChart')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('summary','App\Tax')
                            <li data-toggle="tooltip" title="{{__('sidebar.annualTaxesChart')}}">
                                <a href="{{route('tax.detail')}}">
                                    <span class="sub-item">{{__('sidebar.annualTaxesChart')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.dailyMonthlyPeriodReports')}}">
                    <a data-toggle="collapse" href="#maps">
                        <i class="fas fa-fw text-info fa-file-alt" aria-hidden="true"></i>
                        <p>{{__('sidebar.reports')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="maps">
                        <ul class="nav nav-collapse" id="reports">
                            @can('report','App\Product')
                            <li data-toggle="tooltip" title="{{__('sidebar.outOfStockProductsWithlowQuantityImpacts')}}">
                                <a href="{{route('product.inventory')}}">
                                    <span class="sub-item">{{__('sidebar.inventoryAlerts')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('report','App\Purchase')
                            <li data-toggle="tooltip" title="{{__('sidebar.costReportTitle')}}">
                                <a href="{{route('cost.report')}}">
                                    <span class="sub-item">{{__('sidebar.costReport')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('report','App\Sale')
                            <li data-toggle="tooltip" title="{{__('sidebar.saleReportTitle')}}">
                                <a href="{{route('sale.report')}}">
                                    <span class="sub-item"> {{__('sidebar.saleReport')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('report','App\Tax')
                            <li data-toggle="tooltip" title="{{__('sidebar.taxReportTitle')}}">
                                <a href="{{route('tax.report')}}">
                                    <span class="sub-item"> {{__('sidebar.taxReport')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('view','App\Report')
                            <li data-toggle="tooltip" title="{{__('sidebar.savedReportTitle')}}">
                                <a href="{{route('report.index')}}">
                                    <span class="sub-item">{{__('sidebar.savedReports')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @can('backup','App\Setting')
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.backupTitle')}}">
                    <a href="{{route('backup.index')}}">
                        <i class="fas fa-fw text-info fa-database" aria-hidden="true"></i>
                        <p>{{__('sidebar.backup')}}</p>
                    </a>
                </li>
                @endcan
                @can('view','App\UserActivity')
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.logActivityTitle')}}">
                    <a href="{{route('logs.index')}}">
                        <i class="fa fa-history fa-fw text-info aria-hidden="true"></i>
                        <p>{{__('sidebar.activityLogs')}}</p>
                    </a>
                </li>
                @endcan
                @can('view','App\Setting')
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.masterConfiguration')}}">
                    <a href="{{route('setting.index')}}">
                        <i class="fas fa-fw text-info fa-cogs" aria-hidden="true"></i>
                        <p> {{__('sidebar.settings')}}</p>
                    </a>
                </li>
                @endcan
                <li class="nav-item" data-toggle="tooltip" title="{{__('sidebar.userManageTitle')}}">
                    <a data-toggle="collapse" href="#custompages">
                        <i class="fas fa-fw text-info fa-users" aria-hidden="true"></i>
                        <p>{{__('sidebar.userControls')}}</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="custompages">
                        <ul class="nav nav-collapse" id="users">
                            @can('create','App\User')
                            <li data-toggle="tooltip" title="{{__('sidebar.addNewUser')}}">
                                <a href="{{route('register')}}">
                                    <span class="sub-item"> {{__('sidebar.addUser')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\User')
                            <li data-toggle="tooltip" title="{{__('sidebar.manageUsersTitle')}}">
                                <a href="{{route('user.index')}}">
                                    <span class="sub-item"> {{__('sidebar.manageUsers')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('create','App\Group')
                            <li data-toggle="tooltip" title="{{__('sidebar.permAddTitle')}}">
                                <a href="{{route('group.create')}}">
                                    <span class="sub-item">{{__('sidebar.newGroup')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manage','App\Group')
                            <li data-toggle="tooltip" title="{{__('sidebar.manageGroupTitle')}}">
                                <a href="{{route('group.index')}}">
                                    <span class="sub-item">{{__('sidebar.manageGroup')}}</span>
                                </a>
                            </li>
                            @endcan
                            @can('manageRequest','App\Group')
                            <li data-toggle="tooltip" title="{{__('sidebar.permRequestTitle')}}">
                                <a href="{{route('group.requests')}}">
                                    <span class="sub-item"> {{__('sidebar.permissionRequests')}}</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item" data-toggle="tooltip" title="{{__('common.logout')}}">
                    <a  href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fas fa-fw text-info fa-sign-out-alt" aria-hidden="true"></i>
                        <p>{{__('common.logout')}}</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
