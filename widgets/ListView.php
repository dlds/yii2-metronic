<?php

/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals/license/
 */

namespace dlds\metronic\widgets;

use yii\helpers\Url;
use dlds\metronic\bundles\ListViewAsset;
use dlds\metronic\bundles\ListViewSortableAsset;

class ListView extends \yii\widgets\ListView {

    /**
     * @var boolean indicates if grid is sortable
     */
    public $sortable = false;

    /**
     * Inits widget
     */
    public function init()
    {
        parent::init();

        $this->initSortable();
    }

    /**
     * Inits sortable behavior
     */
    protected function initSortable()
    {
        if ($this->sortable)
        {
            $this->sortable = Url::toRoute($this->sortable);

            $view = $this->getView();
            $view->registerJs("jQuery('#{$this->id}').SortableListView('{$this->sortable}');");
            ListViewSortableAsset::register($view);
        }
    }

}
