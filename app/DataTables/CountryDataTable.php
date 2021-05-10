<?php

namespace App\DataTables;

use App\Country;
use Yajra\DataTables\Services\DataTable;

class CountryDataTable extends DataTable
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
                function ($country) {
                    return '<div title="'.trans('table.ViewFullAndManage').'">
           <a class="btn btn-sm" href="'.route('country.show', $country->id) . '">
           <i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i>
           </a>
           </div>';
                }
            );
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Country $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Country $model)
    {
        return $model->newQuery()->select(
            [
            'code',
            'name',
            'id',
            'created_at',
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
            'created_at' => ['title' => trans('table.createdAt') ],
            'name' => ['title' => trans('table.countryName') ],
            'code' => ['title' => trans('table.countryCode') ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Country_' . date('YmdHis');
    }
}
