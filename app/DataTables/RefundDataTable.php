<?php

namespace App\DataTables;

use App\Refund;
use Yajra\DataTables\Services\DataTable;

class RefundDataTable extends DataTable
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
                function ($refund) {
                    return '<div title="'.trans('table.ViewFullAndManage').'">
           <a class="btn btn-sm" href="'.route('refund.show', $refund->id) . '">
             <i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>
           </a>
           </div>';
                }
            );
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Refund $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Refund $model)
    {
        return $model->newQuery()->select(
            ['created_at','return_items','tax_rate','tax_amount','refundable','id','charge_rate','charge_amount','refund_price','reference',
            ]
        );
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
            'reference' => ['title' => trans('table.reference')],
            'tax_rate' => ['title' => trans('table.taxRate')],
            'tax_amount' => ['title' => trans('table.taxAmount')],
            'charge_rate' => ['title' => trans('table.chargeRate')],
            'charge_amount' => ['title' => trans('table.chargeAmount')],
            'return_items' => ['title' => trans('table.returnItems')],
            'refund_price' => ['title' => trans('table.refundPrice')],
            'refundable' => ['title' => trans('table.refundable')],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Refund_' . date('YmdHis');
    }
}
