<?php

namespace App\DataTables;

use App\Sale;
use Yajra\DataTables\Services\DataTable;

class SaleDataTable extends DataTable
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
                function ($sale) {
                    return '<div title="'.trans('table.ViewFullAndManage').'">
           <a class="btn btn-sm" href="'.route('sale.show', $sale->id) . '">
          <i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>
           </a>
           </div>';
                }
            );
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Sale $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Sale $model)
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
            'reference' => ['title' => trans('table.reference')],
            'order_tax' => ['title' => trans('table.taxRate')],
            'tax_amount' => ['title' => trans('table.taxAmount')],
            'discount_rate' => ['title' => trans('table.discountRate')],
            'discount_amount' => ['title' => trans('table.discountAmount')],
            'enter_amount' => ['title' => trans('table.enterAmount')],
            'payable' => ['title' => trans('table.payable')],
            'change' => ['title' => trans('table.change')],
            'total_price' => ['title' => trans('table.totalPrice')],
            'total_items' => ['title' => trans('table.totalItems')],
            'biller_detail' => ['title' => trans('table.billerDetail')],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Sale_' . date('YmdHis');
    }
}
