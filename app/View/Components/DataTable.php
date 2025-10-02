<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DataTable extends Component
{
    public $tableId;
    public $cardTitle;
    public $ajaxUrl;
    public $moduleName;
    public $columns;
    public $showBulkActions;
    public $statusChangeRoute;
    public $singleDeleteRoute;
    public $multipleDeleteRoute;

    public function __construct(
        $id,
        $title = 'Data Details',
        $ajaxUrl = null,
        $moduleName = null,
        $columns = [],
        $showBulkActions = true,
        $statusChangeRoute = null,
        $singleDeleteRoute = null,
        $multipleDeleteRoute = null
    ) {
        $this->tableId = $id;
        $this->cardTitle = $title;
        $this->ajaxUrl = $ajaxUrl ?? url()->current();
        $this->moduleName = $moduleName;
        $this->columns = $columns;
        $this->showBulkActions = $showBulkActions;
        $this->statusChangeRoute = $statusChangeRoute;
        $this->singleDeleteRoute = $singleDeleteRoute;
        $this->multipleDeleteRoute = $multipleDeleteRoute;
    }

    public function render()
    {
        return view('components.data-table');
    }
}
