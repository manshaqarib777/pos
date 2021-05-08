<?php

namespace App\DataTables;

use App\Customer;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn(
                'action',
                function ($customer) {
                    return '<div title="'.trans('table.ViewFullAndManage').'">
               <a class="btn btn-sm" href="'.route('customer.show', $customer->id) . '">
                <i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>
               </a>
               </div>';
                }
            );
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Customer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Customer $model)
    {
        return $model->newQuery()->select('*');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction()
            ->parameters();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'created_at' => ['title' => trans('table.createdAt')],
            'name' => ['title' => trans('table.customerName')],
            'email' => ['title' => trans('table.email')],
            'phone' => ['title' => trans('table.phone')],
            'vat' => ['title' => trans('table.VAT')],
            'address' => ['title' => trans('table.address')]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Customer_' . date('YmdHis');
    }
}
