<div class="row">
    <div class="col-md-3">
        <table class="table table-striped">
            <caption>Entries Permission</caption>
            <thead class="bg-warning">
                <tr>
                    <th scope="row" class="th-with-50">{{__('group.entries')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="product_add" name="product_add" value="1" {{$per->product_add? 'checked':''}}>
                            <label class="custom-control-label" for="product_add">{{__('group.addNewProduct')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="category_add"  name="category_add" value="1" {{$per->category_add? 'checked':''}}>
                            <label class="custom-control-label" for="category_add">{{__('group.newCategory')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="subcategory_add"  name="subcategory_add" value="1" {{$per->subcategory_add? 'checked':''}}>
                            <label class="custom-control-label" for="subcategory_add">{{__('group.newSubcategory')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="supplier_add"  name="supplier_add" value="1" {{$per->supplier_add? 'checked':''}}>
                            <label class="custom-control-label" for="supplier_add">{{__('group.newSupplier')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customer_add"  name="customer_add" value="1" {{$per->customer_add? 'checked':''}}>
                            <label class="custom-control-label" for="customer_add">{{__('group.newCustomer')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="purchase_add"  name="purchase_add" value="1" {{$per->purchase_add? 'checked':''}}>
                            <label class="custom-control-label" for="purchase_add">{{__('group.makePurchase')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="expense_add"  name="expense_add" value="1" {{$per->expense_add? 'checked':''}}>
                            <label class="custom-control-label" for="expense_add">{{__('group.addExpense')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="warehouse_add"  name="warehouse_add" value="1" {{$per->warehouse_add? 'checked':''}}>
                            <label class="custom-control-label" for="warehouse_add">{{__('group.newWarehouse')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="tax_add"  name="tax_add" value="1" {{$per->tax_add? 'checked':''}}>
                            <label class="custom-control-label" for="tax_add">{{__('group.defineTaxMethod')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="payment_add"  name="payment_add" value="1" {{$per->payment_add? 'checked':''}}>
                            <label class="custom-control-label" for="payment_add">{{__('group.addPaymentGateway')}}</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped">
            <caption>Logs</caption>
            <thead class="bg-warning">
                <tr>
                    <th scope="row" class="th-with-50">{{__('group.logActivity')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="logs_view"  name="logs_view" value="1" {{$per->logs_view? 'checked':''}}>
                            <label class="custom-control-label" for="logs_view">{{__('group.viewActivityLogs')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="logs_manage"  name="logs_manage" value="1" {{$per->logs_manage? 'checked':''}}>
                            <label class="custom-control-label" for="logs_manage">{{__('group.manageActivityLogs')}}</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-striped">
            <caption>Management Permission</caption>
            <thead class="bg-warning">
                <tr>
                    <th scope="row" class="th-with-50">{{__('group.management')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="product_manage"  name="product_manage" value="1" {{$per->product_manage? 'checked':''}}>
                            <label class="custom-control-label" for="product_manage">{{__('group.manageProducts')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="category_manage"  name="category_manage" value="1" {{$per->category_manage? 'checked':''}}>
                            <label class="custom-control-label" for="category_manage">{{__('group.manageCategories')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="subcategory_manage"  name="subcategory_manage" value="1" {{$per->subcategory_manage? 'checked':''}}>
                            <label class="custom-control-label" for="subcategory_manage">{{__('group.manageSubcategories')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="supplier_manage"  name="supplier_manage" value="1" {{$per->supplier_manage? 'checked':''}}>
                            <label class="custom-control-label" for="supplier_manage">{{__('group.manageSuppliers')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customer_manage"  name="customer_manage" value="1" {{$per->customer_manage? 'checked':''}}>
                            <label class="custom-control-label" for="customer_manage">{{__('group.manageCustomers')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="purchase_manage"  name="purchase_manage" value="1" {{$per->purchase_manage? 'checked':''}}>
                            <label class="custom-control-label" for="purchase_manage">{{__('group.managePurchaseOrders')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="expense_manage"  name="expense_manage" value="1" {{$per->expense_manage? 'checked':''}}>
                            <label class="custom-control-label" for="expense_manage">{{__('group.manageExpenseVouchers')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="warehouse_manage"  name="warehouse_manage" value="1" {{$per->warehouse_manage? 'checked':''}}>
                            <label class="custom-control-label" for="warehouse_manage">{{__('group.manageWarehouses')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="tax_manage"  name="tax_manage" value="1" {{$per->tax_manage? 'checked':''}}>
                            <label class="custom-control-label" for="tax_manage">{{__('group.manageTaxMethods')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="payment_manage"  name="payment_manage" value="1" {{$per->payment_manage? 'checked':''}}>
                            <label class="custom-control-label" for="payment_manage">{{__('group.managePaymentGateways')}}</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped">
            <caption>Finance Related Permissions</caption>
            <thead class="bg-warning">
                <tr>
                    <th scope="row" class="th-with-50">{{__('group.financeCharts')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="sale_summary"  name="sale_summary" value="1" {{$per->sale_summary? 'checked':''}}>
                            <label class="custom-control-label" for="sale_summary">{{__('group.salesCharts')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="refund_summary"  name="refund_summary" value="1" {{$per->refund_summary? 'checked':''}}>
                            <label class="custom-control-label" for="refund_summary">{{__('group.refundsCharts')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="expense_summary"  name="expense_summary" value="1" {{$per->expense_summary? 'checked':''}}>
                            <label class="custom-control-label" for="expense_summary">{{__('group.expensesCharts')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="purchase_summary"  name="purchase_summary" value="1" {{$per->purchase_summary? 'checked':''}}>
                            <label class="custom-control-label" for="purchase_summary">{{__('group.purchasesCharts')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="tax_summary"  name="tax_summary" value="1" {{$per->tax_summary? 'checked':''}}>
                            <label class="custom-control-label" for="tax_summary">{{__('group.taxesCharts')}}</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-striped">
            <caption>Setting Permissions</caption>
            <thead class="bg-warning">
                <tr>
                    <th scope="row" class="th-with-50">{{__('group.appSettings')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="setting_view"  name="setting_view" value="1" {{$per->setting_view? 'checked':''}}>
                            <label class="custom-control-label" for="setting_view">{{__('group.viewMasterSetting')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="setting_general"  name="setting_general" value="1" {{$per->setting_general? 'checked':''}}>
                            <label class="custom-control-label" for="setting_general">{{__('group.updateGeneralSetting')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="setting_logo"  name="setting_logo" value="1" {{$per->setting_logo? 'checked':''}}>
                            <label class="custom-control-label" for="setting_logo">{{__('group.appLogo')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="setting_mail"  name="setting_mail" value="1" {{$per->setting_mail? 'checked':''}}>
                            <label class="custom-control-label" for="setting_mail">{{__('group.mailConfiguration')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="setting_product_default"  name="setting_product_default" value="1" {{$per->setting_product_default? 'checked':''}}>
                            <label class="custom-control-label" for="setting_product_default">{{__('group.newProductDefaults')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="setting_impects"  name="setting_impects" value="1" {{$per->setting_impects? 'checked':''}}>
                            <label class="custom-control-label" for="setting_impects">{{__('group.setInventoryImpacts')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="setting_pos"  name="setting_pos" value="1" {{$per->setting_pos? 'checked':''}}>
                            <label class="custom-control-label" for="setting_pos">{{__('group.posConfiguration')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="setting_quick_mail"  name="setting_quick_mail" value="1" {{$per->setting_quick_mail? 'checked':''}}>
                            <label class="custom-control-label" for="setting_quick_mail">{{__('group.sendQuickMail')}}</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped">
            <caption>Report Permissions</caption>
            <thead class="bg-warning">
                <tr>
                    <th scope="row" class="th-with-50">{{__('group.reports')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="product_inventory"  name="product_inventory" value="1" {{$per->product_inventory? 'checked':''}}>
                            <label class="custom-control-label" for="product_inventory">{{__('group.inventoryAlerts')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="purchase_report"  name="purchase_report" value="1" {{$per->purchase_report? 'checked':''}}>
                            <label class="custom-control-label" for="purchase_report">{{__('group.generateCostReport')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="sale_report"  name="sale_report" value="1" {{$per->sale_report? 'checked':''}}>
                            <label class="custom-control-label" for="sale_report">{{__('group.generateSaleReport')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="tax_report"  name="tax_report" value="1" {{$per->tax_report? 'checked':''}}>
                            <label class="custom-control-label" for="tax_report">{{__('group.generateTaxReport')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="reports_save"  name="reports_save" value="1" {{$per->reports_save? 'checked':''}}>
                            <label class="custom-control-label" for="reports_save">{{__('group.canSaveReport')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="reports_view"  name="reports_view" value="1" {{$per->reports_view? 'checked':''}}>
                            <label class="custom-control-label" for="reports_view">{{__('group.canViewSavedReports')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="reports_manage"  name="reports_manage" value="1" {{$per->reports_manage? 'checked':''}}>
                            <label class="custom-control-label" for="reports_manage">{{__('group.manageSavedReport')}}</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-3">
        <table class="table table-striped">
            <caption>Chapter Permission</caption>
            <thead class="bg-warning">
                <tr>
                    <th scope="row" class="th-with-50">{{__('group.chapterRegister')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chapter_open"  name="chapter_open" value="1" {{$per->chapter_open? 'checked':''}}>
                            <label class="custom-control-label" for="chapter_open">{{__('group.openRegisterChapter')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chapter_close"  name="chapter_close" value="1" {{$per->chapter_close? 'checked':''}}>
                            <label class="custom-control-label" for="chapter_close">{{__('group.closeRegisterChapter')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="chapter_manage"  name="chapter_manage" value="1" {{$per->chapter_manage? 'checked':''}}>
                            <label class="custom-control-label" for="chapter_manage">{{__('group.manageRegisterChapter')}}</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped">
            <caption>POS Permissions</caption>
            <thead class="bg-warning">
                <tr>
                    <th scope="row" class="th-with-50">{{__('group.pos')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="sale_create"  name="sale_create" value="1" {{$per->sale_create? 'checked':''}}>
                            <label class="custom-control-label" for="sale_create">{{__('group.canSaleItem')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="refund_create"  name="refund_create" value="1" {{$per->refund_create? 'checked':''}}>
                            <label class="custom-control-label" for="refund_create">{{__('group.canRefund')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="sale_manage"  name="sale_manage" value="1" {{$per->sale_manage? 'checked':''}}>
                            <label class="custom-control-label" for="sale_manage">{{__('group.manageSaleOrders')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="refund_manage"  name="refund_manage" value="1" {{$per->refund_manage? 'checked':''}}>
                            <label class="custom-control-label" for="refund_manage">{{__('group.manageRefundOrders')}}</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped">
            <caption>User Permission</caption>
            <thead class="bg-warning">
                <tr>
                    <th scope="row" class="th-with-50">Users</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="user_create"  name="user_create" value="1" {{$per->user_create? 'checked':''}}>
                            <label class="custom-control-label" for="user_create">{{__('group.createNewUser')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="user_manage"  name="user_manage" value="1" {{$per->user_manage? 'checked':''}}>
                            <label class="custom-control-label" for="user_manage">{{__('group.userManagement')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="user_edit"  name="user_edit" value="1" {{$per->user_edit? 'checked':''}}>
                            <label class="custom-control-label" for="user_edit">{{__('group.userEdit')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="group_add"  name="group_add" value="1" {{$per->group_add? 'checked':''}}>
                            <label class="custom-control-label" for="group_add">{{__('group.addPermissionGroup')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="group_manage"  name="group_manage" value="1" {{$per->group_manage? 'checked':''}}>
                            <label class="custom-control-label" for="group_manage">{{__('group.managePermissionGroup')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="group_request"  name="group_request" value="1" {{$per->group_request? 'checked':''}}>
                            <label class="custom-control-label" for="group_request">{{__('group.canRequestDedicatedPermissionGroup')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="group_request_manage"  name="group_request_manage" value="1" {{$per->group_request_manage? 'checked':''}}>
                            <label class="custom-control-label" for="group_request_manage">{{__('group.manageDedicatedPermissionsRequests')}}</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-striped">
            <caption>Miscellaneous Permissions</caption>
            <thead class="bg-warning">
                <tr>
                    <th scope="row" class="th-with-50">{{__('group.miscellaneous')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="setting_dashboard"  name="setting_dashboard" value="1" {{$per->setting_dashboard? 'checked':''}}>
                            <label class="custom-control-label" for="setting_dashboard">{{__('group.dashboard')}}</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="setting_backup"  name="setting_backup" value="1" {{$per->setting_backup? 'checked':''}}>
                            <label class="custom-control-label" for="setting_backup">{{__('group.databaseBackup')}}</label>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
