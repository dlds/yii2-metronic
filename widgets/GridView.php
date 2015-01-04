<?php

/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals/license/
 */

namespace dlds\metronic\widgets;

use yii\helpers\Html;
use dlds\metronic\bundles\GridViewAsset;

class GridView extends \yii\grid\GridView {

    const FILTER_POS_OFF = 'off';

    /**
     * @var bool indicates whether the gridView is responsive.
     */
    public $responsive = false;

    /**
     * @var array the HTML attributes for the grid table element
     */
    public $tableOptions = ['class' => 'table table-striped table-bordered table-hover dataTable'];

    /**
     * @var array the HTML attributes for the table header row
     */
    public $headerRowOptions = ['class' => 'heading'];

    /**
     * @var string grid view layout
     */
    public $layout = "{items}\n{summary}\n{pager}";

    public function init()
    {
        parent::init();
        $this->initVisible();
        $this->initSortable();

        //GridViewAsset::register($this->view);
    }

    /**
     * Renders the data models for the grid view.
     */
    public function renderItems()
    {
        $content = array_filter([
            $this->renderCaption(),
            $this->renderColumnGroup(),
            $this->showHeader ? $this->renderTableHeader() : false,
            $this->showFooter ? $this->renderTableFooter() : false,
            $this->renderTableBody(),
        ]);

        $table = Html::tag('table', implode("\n", $content), $this->tableOptions);
        if ($this->responsive)
        {
            $table = Html::tag('div', $table, ['class' => 'table-responsive']);
        }
        else
        {
            $table = Html::tag('div', $table, ['class' => 'table-scrollable']);
        }

        return $table;
    }

    protected function initVisible()
    {
        $columns = $this->getStorageColumns();
        if (empty($columns))
        {
            return;
        }
        foreach ($this->columns as $i => $column)
        {
            if (array_search($i, $columns) === false)
            {
                unset($this->columns[$i]);
            }
        }
    }

    protected function initSortable()
    {
        $positions = $this->getStorageColumns();
        if (empty($positions))
        {
            return;
        }
        uksort(
                $this->columns, function ($a, $b) use ($positions) {
            $aIndex = array_search($a, $positions);
            $bIndex = array_search($b, $positions);
            if ($aIndex == $bIndex)
            {
                return 0;
            }

            return ($aIndex < $bIndex) ? -1 : 1;
        }
        );
    }

    protected function getStorageColumns()
    {
        return [];
    }

}
