<?php

namespace App\DataTables;

use App\Warehouse;
use Yajra\DataTables\Services\DataTable;

class WarehouseDataTable extends DataTable
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
                function ($warehouse) {
                    return '<div title="'.trans('table.ViewFullAndManage').'">
               <a class="btn btn-sm" href="'.route('warehouse.show', $warehouse->id) . '">
                <i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>
               </a>
               </div>';
                }
            );
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Warehouse $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Warehouse $model)
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
            'code' => ['title' => trans('table.code')],
            'name' => ['title' => trans('table.name')],
            'address' => ['title' => trans('table.address')],
            'phone' => ['title' => trans('table.phone')],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Warehouse_' . date('YmdHis');
    }
}
